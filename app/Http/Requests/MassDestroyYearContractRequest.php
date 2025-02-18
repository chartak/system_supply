<?php

namespace App\Http\Requests;

use App\Models\YearContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyYearContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('year_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:year_contracts,id',
        ];
    }
}