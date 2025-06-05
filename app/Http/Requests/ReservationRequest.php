<?php

namespace App\Http\Requests;

use App\Rules\ValidateDays;
use App\Services\Utility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
{
    protected $table = [
        'office' => 'desks',
        'parking' => 'parks'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' => 'required|json',
            'to' => 'required|json',
            'from-time' => [new ValidateDays()],
            // 'from.minute' => Rule::notIn(['12']),
            'number' => [
                'required',
                Rule::unique($this->table[getDashboardType()], 'number')->where(function ($query) {
                    $query->where('user_id', auth()->user()->id)
                        ->where('soft_delete', 'false')
                        ->where('state', '=', 'active')
                        ->where('start_date', Utility::makePreciseDate('from', request()));

                    $dashboardType = getDashboardType();
                    $startDate = Utility::makePreciseDate('from', request());
                    $endDate = Utility::makePreciseDate('to', request(), true);

                    $query->whereRaw("
                                    NOT EXISTS (
                                        SELECT 1
                                        FROM cancellations c
                                        WHERE c.number = {$this->table[$dashboardType]}.number
                                        AND c.user_id = ?
                                        AND c.soft_delete = 'false'
                                        AND (
                                            c.start_date BETWEEN ? AND ?
                                            OR c.end_date BETWEEN ? AND ?
                                            OR (c.start_date <= ? AND c.end_date >= ?)
                                        )
                                    )
                                ", [
                        auth()->user()->id,
                        $startDate, $endDate, // c.start_date BETWEEN
                        $startDate, $endDate, // c.end_date BETWEEN
                        $startDate, $endDate  // c.start_date <= AND c.end_date >=
                    ]);
                })
            ],
        ];
    }


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'from.required' => 'Start date needed',
            'from.json' => 'Wrong format for start date',
            'to.required' => 'End date needed',
            'to.json' => 'Wrong format for end date',
            'number.required' => 'Choose the place',
            'number.unique' => 'Number already taken',
        ];
    }
}
