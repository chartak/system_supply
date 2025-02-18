<?php

namespace App\Http\Requests;

use App\Models\WeekContractProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWeekContractProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('week_contract_product_edit');
    }

    public function rules()
    {
        return [
            'week_contract_id' => [
                'required',
                'integer',
            ],
            'quantity' => [
                'numeric',
                'required',
            ],
            'year_con_prods.*' => [
                'integer',
            ],
            'year_con_prods' => [
                'required',
                'array',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}