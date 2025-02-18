<?php

namespace App\Http\Requests;

use App\Models\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_edit');
    }

    public function rules()
    {
        return [
            // 'cpv' => [
            //     'required',
            //     'nullable',
            //     'integer',
            //     'min:-2147483648',
            //     'max:2147483647',
            //     'unique:products,cpv,' . request()->route('product')->id,
            // ],
            'cpv' => [
                'string',
                'min:8',
                'max:15',
                'required',
                'unique:products,cpv,' . request()->route('product')->id,
            ],
            'name' => [
                'string',
                'required',
            ],
            'unit_measurementid_id' => [
                'required',
                'integer',
            ],
        ];
    }
}