<?php


namespace App\Services;

use App\Models\Park as ParkModel;
use App\Models\Spot;
use App\Notifications\NotifyUser;
use Illuminate\Support\Facades\Gate;


class Park implements ReservationInterface
{
    protected $park;
    public $request;

    /**
     * Park constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->park = new ParkModel();
        $this->request = $request;
    }

    /**
     * @return string|string[]
     */
    public function getNumber()
    {
        $spot = Spot::find($this->request->number);

        return (str_contains($spot->number, 'A'))
            ? (str_replace("A", "", $spot->number))
            : (str_contains($spot->number, 'B')
                ? str_replace("B", "", $spot->number) : $spot->number);
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
        $this->park->number = $this->request->number;
        $this->park->start_date = Utility::makePreciseDate('from', $this->request);
        $this->park->end_date = Utility::makePreciseDate('to', $this->request, true);
        $this->park->start_hour = Utility::makePreciseHour('from', $this->request);
        $this->park->end_hour = Utility::makePreciseHour('to', $this->request, true);
        $this->park->state = 'active';
        $this->park->user_id = auth()->user()->id;
        $this->park->spot_id = $this->request->number;

        $response = Gate::inspect('store', $this->park);

        if ($response->allowed()) {
            $this->save();
        } else {
            return back()->with('error', 'Unsuccessful: ' . $response->message());
        }
    }


    public function save(): void
    {
        if ($this->park->save()) {
            //send an email
            $this->fireEmail();
            return;
        }
        showFlash("error", "Reservation unsuccessful!");
    }

    public function sendText(): string
    {
        return 'Your reservation for ' . $this->park->spot->number . ' | floor '
            . $this->park->spot->floor . ' (from ' . convertFromUnix($this->park->start_date) . ' to '
            . convertFromUnix($this->park->end_date) . ')' . ' has successfully been made.';
    }

    public function update($number)
    {
        $park = ParkModel::findOrFail($number);

        $park->soft_delete = true;


        ($park->save())
            ? showFlash("success", "Reservation deleted successfully.")
            : showFlash("error", "Reservation could NOT be deleted!");

        return;
    }
}
