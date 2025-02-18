<?php

namespace App\Http\Requests;

use App\Models\WeekContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWeekContractRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('week_contract_create');
    }

    public function rules()
    {
        return [
            'year_contracts.*' => [
                'integer',
            ],
            'year_contracts' => [
                'required',
                'array',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'wk_con_file' => [
                'array',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}