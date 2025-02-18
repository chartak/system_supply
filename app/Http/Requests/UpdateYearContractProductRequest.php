<?php

namespace App\Http\Requests;

use App\Models\YearContractProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateYearContractProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('year_contract_product_edit');
    }

    public function rules()
    {
        return [
            'productid_id' => [
                'required',
                'integer',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'year_contractid_id' => [
                'required',
                'integer',
            ],
            'price' => [
                'required',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}