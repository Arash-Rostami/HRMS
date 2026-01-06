<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Profile;
use App\Services\api\SmsOperator;
use App\Services\RandomMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;


class Timetable extends Component
{
    public int $currentYear;
    public int $currentMonth;
    public int $currentDay;
    public array $smsSentStatus = [];
    public array $emptyDays = [];
    public array $calendarData = [];
    public array $selectedDayEvents;
    public array $persianMonthIcons = ["🌼", "🦋", "🌿", "🌞", "🏝️", "🍂", "🍁", "🌦️", "🌧️", "❄", "⛄", "🏔️"];
    public array $eventIcons = ["سالگرد" => "🥂", "تولد" => "🎂", "رویدادها" => "📅"];
    public array $persianWeekdayNames = ["شنبه", "یکشنبه", "دوشنبه", "سه‌شنبه", "چهارشنبه", "پنجشنبه", "جمعه"];
    public bool $isConfirmModalOpen = false;
    public string $receptor = "";
    public string $selectedEventType = "";
    public bool $messageAbility;

    public function createCalendar()
    {
        $this->resetCalenderData();

        // Create the date based on month and year
        $persianDate = new Jalalian($this->currentYear, $this->currentMonth, 1);

        // Create an array of empty cells for days before the 1st day of the month
        $this->emptyDays = array_fill(0, $persianDate->getDayOfWeek(), null);

        // Create an array of day elements for the month
        $dayElements = range(1, $persianDate->getDaysOf($this->currentMonth));

        // cache profile and event data for better performance
        $profiles = $this->getCachedProfiles();
        $events = $this->getCachedEvents();

        // to avoid sending twice
        $this->initializeSmsSentStatus($profiles);


        foreach ($dayElements as $day) {
            $isCurrentDay = $this->isCurrentDay(Jalalian::now(), $day);

            list($birthdays, $startDates, $otherEvents) = $this->getBirthAndStartAndOtherDates($profiles, $events, $day);

            $this->calendarData[] = [
                'day' => $day,
                'isCurrentDay' => $isCurrentDay,
                'birthDates' => $birthdays,
                'startDates' => $startDates,
                'otherEvents' => $otherEvents,
            ];
        }
    }

    public function loadEvents($day = null)
    {
        $this->day = $day ?? Jalalian::now()->getDay();

        // Check if it's the current day and load the message ability
        $this->messageAbility = $this->isCurrentDay(Jalalian::now(), $this->day);

        $dayData = $this->calendarData[$this->day - 1];

        $this->selectedDayEvents = [
            'birthDates' => collect($dayData['birthDates']),
            'startDates' => collect($dayData['startDates']),
            'otherEvents' => collect($dayData['otherEvents']),
        ];
    }

    public function mount()
    {
        $now = Jalalian::now();
        $this->currentYear = $now->getYear();
        $this->currentMonth = $now->getMonth();
        $this->createCalendar();
    }

    public function navigateToNextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear += 1;
        }
        $this->createCalendar();
    }

    public function navigateToPreviousMonth()
    {
        $this->currentMonth--;
        if ($this->currentMonth < 1) {
            $this->currentMonth = 12;
            $this->currentYear -= 1;
        }
        $this->createCalendar();
    }

    public function render()
    {
        return view('components.user.calendar.timetable');
    }

    public function sendSMS()
    {
        $smsService = new SmsOperator();

        $message = ($this->selectedEventType == 'birthDates')
            ? RandomMessage::getBDayMessage()
            : RandomMessage::getAnniversaryMessage();

        if ($smsService->send($this->receptor, $message)) {

            // fade the message option
            $this->smsSentStatus[$this->receptor] = true;

            //show success message
            $this->dispatchBrowserEvent('open-toast');
        }
    }

    private function compareDayAndMonth(Carbon $data, Carbon $jalaliDate): bool
    {
        return $data->month == $jalaliDate->format("m") && $data->day == $jalaliDate->format("d");
    }

    private function getBirthAndStartAndOtherDates($profiles, $events, $day): array
    {
        $jalaliDateObj = new Jalalian($this->currentYear, $this->currentMonth, $day);
        $jalaliDateCarbon = CalendarUtils::createCarbonFromFormat(
            'Y-m-d',
            sprintf('%d-%02d-%02d', $this->currentYear, makeDoubleDigit($this->currentMonth), makeDoubleDigit($day))
        );

        return [
            $this->getBirthDates($profiles, $jalaliDateObj),
            $this->getStartDates($profiles, $jalaliDateCarbon),
            $this->getOtherEvents($events, $jalaliDateCarbon),
        ];
    }

    private function getBirthDates($profiles, \Morilog\Jalali\Jalalian $jalaliDate)
    {
        return $profiles->filter(function ($profile) use ($jalaliDate) {
            if (!$profile->birthdate) return false;

            $jalaliBirth = \Morilog\Jalali\Jalalian::fromCarbon(Carbon::parse($profile->birthdate));

            return $jalaliBirth->getMonth() === $jalaliDate->getMonth() && $jalaliBirth->getDay() === $jalaliDate->getDay();
        });
    }

    private function getCachedEvents()
    {
        return Cache::remember("events:{$this->currentYear}-{$this->currentMonth}",
            now()->addMinutes(30), function () {
                return Event::all();
            });
    }

    private function getCachedProfiles()
    {
        return Cache::remember('profiles',
            now()->addMinutes(30), function () {
                return Profile::with('user')
                    ->whereHas('user', function ($query) {
                        $query->where('status', 'active');
                    })->get();
            });
    }

    private function getOtherEvents(\Illuminate\Database\Eloquent\Collection|array $events, \Carbon\Carbon $jalaliDate)
    {
        return $events->filter(function ($event) use ($jalaliDate) {
            return $this->compareDayAndMonth(Carbon::parse($event->date), $jalaliDate);
        });
    }

    private function getStartDates(\Illuminate\Database\Eloquent\Collection|array $profiles, \Carbon\Carbon $jalaliDate): \Illuminate\Database\Eloquent\Collection
    {
        return $profiles->filter(function ($profile) use ($jalaliDate) {
            if (!$profile->start_date) return false;

            $startDate = Carbon::parse($profile->start_date);
            $persianDate = CalendarUtils::toJalali($startDate->year, $startDate->month, $startDate->day);

            // Skip profiles from the current year
            if ($persianDate[0] == $this->currentYear) return false;

            // Compare the extracted month and day with the Jalalian date
            return $this->compareDayAndMonth($startDate, $jalaliDate);
        });
    }

    private function initializeSmsSentStatus($profiles)
    {
        foreach ($profiles as $profile) {
            $this->smsSentStatus[$profile->cellphone] = false;
        }
    }

    private function isCurrentDay(Jalalian $thisDate, mixed $day): bool
    {
        return $thisDate->getDay() == $day &&
            $thisDate->getMonth() == $this->currentMonth &&
            $thisDate->getYear() == $this->currentYear;
    }

    private function resetCalenderData(): void
    {
        $this->emptyDays = [];
        $this->calendarData = [];
    }
}

