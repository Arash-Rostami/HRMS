<?php


namespace App\Services;


use App\Models\Desk as DeskModel;
use App\Models\Seat;
use App\Notifications\NotifyUser;
use Illuminate\Support\Facades\Gate;

class Desk implements ReservationInterface
{
    protected $desk;
    protected $request;

    /**
     * Desk constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->desk = new DeskModel();
        $this->request = $request;
    }

    /**
     * @return string|string[]
     */
    public function getNumber()
    {
        $spot = Seat::find($this->request->number);

        return $spot->number;
    }

    public function fireEmail(): void
    {
        try {
            auth()->user()->notify(new NotifyUser($this));
            //trigger notification
            showFlash("success", "Reservation successful");
        } catch (\Exception $e) {
            showFlash("error", "Reservation successful, yet email notification could
             NOT be sent as the server was not responding!");
        }
    }

    /**
     *store data
     */
    public function getArea()
    {
        $this->desk->number = $this->request->number;
        $this->desk->start_date = Utility::makePreciseDate('from', $this->request);
        $this->desk->end_date = Utility::makePreciseDate('to', $this->request, true);
        $this->desk->start_hour = Utility::makePreciseHour('from', $this->request);
        $this->desk->end_hour = Utility::makePreciseHour('to', $this->request, true);
        $this->desk->state = 'active';
        $this->desk->user_id = auth()->user()->id;
        $this->desk->seat_id = $this->request->number;

        $response = Gate::inspect('store', $this->desk);

        if ($response->allowed()) {
            $this->save();
        } else {
            return back()->with('error', 'Unsuccessful: ' . $response->message());
        }
    }

    public function save(): void
    {
        if ($this->desk->save()) {
            //send an email
            $this->fireEmail();
            return;
        }
        showFlash("error", "Reservation unsuccessful!");
    }

    public function sendText(): string
    {
        return 'Your reservation for ' . $this->desk->seat->number . ' | '
            . $this->desk->seat->extension . ' (from ' . convertFromUnix($this->desk->start_date) . ' to '
            . convertFromUnix($this->desk->end_date) . ')' . ' has successfully been made.';
    }

    public function update($number)
    {
        $desk = DeskModel::findOrFail($number);

        $desk->soft_delete = true;

        ($desk->save())
            ? showFlash("success", "Reservation deleted successfully.")
            : showFlash("error", "Reservation could NOT be deleted!");

        return;
    }
}
