<?php

namespace App\Http\Requests;

use App\Models\YearContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateYearContractRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('year_contract_edit');
    }

    public function rules()
    {
        return [
            'customerid_id' => [
                'required',
                'integer',
            ],
            'supplierid_id' => [
                'required',
                'integer',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'contract_doc' => [
                'array',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}