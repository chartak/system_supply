<?php

namespace App\Http\Requests;

use App\Models\UserInfo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserInfoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_info_create');
    }

    public function rules()
    {
        return [
            'userid_id' => [
                'required',
                'integer',
            ],
            'company' => [
                'string',
                'min:4',
                'max:150',
                'required',
            ],
            'company_email' => [
                'required',
            ],
            'phone' => [
                'string',
                'min:4',
                'max:15',
                'required',
            ],
            'address' => [
                'string',
                'min:4',
                'max:255',
                'required',
            ],
            'bank_name' => [
                'string',
                'max:100',
                'required',
            ],
            'bank_account_number' => [
                'required',
                'integer',
                // 'min:-2147483648',
                // 'max:2147483647000',
            ],
            'type' => [
                'required',
            ],
            'tax_code' => [
                'string',
                'min:2',
                'max:20',
                'nullable',
            ],
        ];
    }
}