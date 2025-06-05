<?php

namespace App\Services;

use App\Models\Cancellation as CancellationModel;
use Illuminate\Support\Facades\Gate;

class Suspension
{

    public function execute($number)
    {
        $record = getDashboardModel()::findOrFail($number);


        // suspension while other cancellation exists
        if (CancellationModel::getThis($record->number)) {

            $this->softDelete($record);
        }

        // suspension while no other cancellation exists
        $cancellation = $this->storeCancellation($record);

        $response = Gate::inspect('suspend', $cancellation);

        if ($response->allowed()) {

            $cancellation->save();
            showFlash("success", "Reservation suspended successfully.");

        } else {
            return back()->with('error', 'Unsuccessful: ' . $response->message());
        }
    }


    public function softDelete($record)
    {
        $record->soft_delete = true;

        if ($record->save()) {
            showFlash("success", "Reservation deleted successfully.");
            return;
        }
        showFlash("error", "Reservation could NOT be deleted!");
        return;
    }


    public function storeCancellation($record): CancellationModel
    {
        return new CancellationModel([
            'number' => $record->number,
            'start_date' =>  Utility::makePreciseDate('from', request()),
            'end_date' =>  Utility::makePreciseDate('to', request(), true),
            'user_id' => auth()->user()->id,
            'booking' => getDashboardType()
        ]);
    }
}
