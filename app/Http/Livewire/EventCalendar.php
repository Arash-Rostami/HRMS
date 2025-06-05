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


class EventCalendar extends Component
{
    public int $currentYear;
    public int $currentMonth;
    public int $currentDay;
    public array $smsSentStatus = [];
    public array $emptyDays = [];
    public array $calendarData = [];
    public array $selectedDayEvents;
    public array $persianMonthIcons = ["🌼", "🦋", "🌿", "🌞", "🏝️", "🍂", "🍁", "🌦️", "🌧️", "❄", "⛄", "🏔️"];
    public array $eventIcons = ["anniversary" => "🥂", "birthday" => "🎂", "events" => "📅"];
    public array $persianWeekdayNames = ["SAT", "SUN", "MON", "TUE", "WED", "THU", "FRI"];
    public bool $isConfirmModalOpen = false;
    public string $receptor = "";
    public string $selectedEventType = "";
    public bool $messageAbility;


    public function mount()
    {
        $now = Jalalian::now();
        $this->currentYear = $now->getYear();
        $this->currentMonth = $now->getMonth();
        $this->createCalendar();
    }


    public function sendSMS()
    {
        $smsService = new SmsOperator();

        $message = ($this->selectedEventType == 'birthDates') ? RandomMessage::getBDayMessage() : RandomMessage::getAnniversaryMessage();

        if ($smsService->send($this->receptor, $message)) {

            // fade the message option
            $this->smsSentStatus[$this->receptor] = true;

            //show success message
            $this->dispatchBrowserEvent('open-toast');
        }
    }

    public function createCalendar()
    {
        $this->resetCalenderData();

        // Create the date based on month and year
        $persianDate = new Jalalian($this->currentYear, $this->currentMonth, 1);

        // Create an array of empty cells for days before the 1st day of the month
        $this->emptyDays = array_fill(0, $persianDate->getDayOfWeek(), null);

        // Create an array of day elements for the month
        $dayElements = range(1, $persianDate->getDaysOf($this->currentMonth));

        // cache profile data for better performance
        $profiles = $this->getCachedProfiles();

        // to avoid sending twice
        $this->initializeSmsSentStatus($profiles);


        foreach ($dayElements as $day) {
            $isCurrentDay = $this->isCurrentDay(Jalalian::now(), $day);

            // fixing bug of Jalalian day for 1403
            list($birthdays, $startDates, $otherEvents) = $this->getBirthAndStartAndOtherDates($profiles,
                $this->currentYear == '1403' ? $day + 1 : $day);


            $this->calendarData[] = [
                'day' => $day,
                'isCurrentDay' => $isCurrentDay,
                'birthDates' => $birthdays,
                'startDates' => $startDates,
                'otherEvents' => $otherEvents,
            ];
        }
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

    public function navigateToNextMonth()
    {
        $this->currentMonth++;
        if ($this->currentMonth > 12) {
            $this->currentMonth = 1;
            $this->currentYear += 1;
        }
        $this->createCalendar();
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


    public function render()
    {
        return view('livewire.event-calendar');
    }


    private function getCachedProfiles()
    {
        return cache()->remember('profiles', now()->addHour(), function () {
            return Profile::with('user')
                ->whereHas('user', function ($query) {
                    $query->where('status', 'active');
                })
                ->get();
        });
    }

    private function initializeSmsSentStatus($profiles)
    {
        foreach ($profiles as $profile) {
            $this->smsSentStatus[$profile->cellphone] = false;
        }
    }

    private function resetCalenderData(): void
    {
        $this->emptyDays = [];
        $this->calendarData = [];
    }

    private function isCurrentDay(Jalalian $thisDate, mixed $day): bool
    {
        return $thisDate->getDay() == $day && $thisDate->getMonth() == $this->currentMonth && $thisDate->getYear() == $this->currentYear;
    }


    private function getBirthAndStartAndOtherDates(\Illuminate\Database\Eloquent\Collection|array $profiles, $day): array
    {

        $jalaliDate = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d',
            $this->currentYear . "-" . makeDoubleDigit($this->currentMonth) . "-" . makeDoubleDigit($day));

        return [$this->getBirthDates($profiles, $jalaliDate), $this->getStartDates($profiles, $jalaliDate), $this->getOtherEvents($jalaliDate)];
    }

    private function getBirthDates(\Illuminate\Database\Eloquent\Collection|array $profiles, \Carbon\Carbon $jalaliDate): \Illuminate\Database\Eloquent\Collection
    {
        return $profiles->filter(function ($profile) use ($jalaliDate) {
            if ($profile->birthdate !== null) {
                // Extract the month and day from the timestamp
                $startDateMonth = date("m", strtotime($profile->birthdate));
                $startDateDay = date("d", strtotime($profile->birthdate));
                $startDateYear = date("Y", strtotime($profile->birthdate));

                // Compare the extracted month and day with the Jalalian date
                return ($startDateMonth == $jalaliDate->format("m")) && ($startDateDay == $jalaliDate->format("d"));
            }
            return false;
        });
    }

    private function getStartDates(\Illuminate\Database\Eloquent\Collection|array $profiles, \Carbon\Carbon $jalaliDate): \Illuminate\Database\Eloquent\Collection
    {
        return $profiles->filter(function ($profile) use ($jalaliDate) {
            if ($profile->start_date === null) {
                return false;
            }

            $startDate = Carbon::parse($profile->start_date);
            $persianDate = CalendarUtils::toJalali($startDate->year, $startDate->month, $startDate->day);

            // Skip profiles from the current year
            if ($persianDate[0] == $this->currentYear) {
                return false;
            }

            // Compare the extracted month and day with the Jalalian date
            return $startDate->month == $jalaliDate->format("m") && $startDate->day == $jalaliDate->format("d");
        });
    }

    private function getOtherEvents($jalaliDate)
    {
        return Event::whereDate('date', '=', $jalaliDate)->get();
    }
}
