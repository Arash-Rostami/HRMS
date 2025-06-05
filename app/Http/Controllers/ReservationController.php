<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Cancellation;
use App\Models\Desk;
use App\Models\Park;
use App\Models\Park as ParkModel;
use App\Models\Spot;
use App\Models\User;
use App\Services\Reservation;
use App\Services\Suspension;
use App\Services\DB;
use App\Services\Desk as DeskService;
use App\Services\Park as ParkService;
use App\Services\ReservationMaker;
use App\Services\Search;
use Illuminate\Http\RedirectResponse;


class ReservationController extends Controller
{

    public function edit($number)
    {
        (new Suspension())->execute($number);

        return back();
    }

    public function list($report)
    {
        $reservations = match ($report) {
            'parking' => DB::showDailyReport(Park::class, now()->timestamp),
            'office' => DB::showDailyReport(Desk::class, now()->timestamp)
        };

        return view('daily-report', compact('reservations', 'report'));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(): \Illuminate\Http\JsonResponse
    {
        $reservation = Search::findByKeyword();

        return response()->json(['user' => $reservation]);
    }

    /**
     * @param $number
     * @return RedirectResponse
     */
    public function show($number): RedirectResponse
    {
        // if query or type of dashboard is not given
        if (isTypeNotGiven()) abort(500, 'Re-log in with right dashboard type!');

        $reservations = showReserveArea($number);

        return back()
            ->with('day', $number)
            ->with('area', $reservations)
            ->with('user', showMyArea($reservations))
            ->with('total', showTotalReservations($reservations))
            ->with('remain', showRemainingReservations($reservations)) ;
    }


    public function store(ReservationRequest $request): RedirectResponse
    {
        //  to save in parking lot in case it is selected
        if (isParking()) {
            $reservation = new ReservationMaker(new ParkService($request));
            $reservation->confirm();
            return back();
        }
        $reservation = new ReservationMaker(new DeskService($request));
        $reservation->confirm();
        return back();
    }


    /**
     * @param $number
     * @return RedirectResponse
     */
    public function update($number): RedirectResponse
    {
        //  to soft-delete in parking lot in case it is selected
        if (isParking()) {
            $reservation = new ReservationMaker(new ParkService(request()));
            $reservation->update($number);
            return back();
        }
        $reservation = new ReservationMaker(new DeskService(request()));
        $reservation->update($number);
        return back();
    }
}
