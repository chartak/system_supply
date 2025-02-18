<?php

namespace App\Http\Requests;

use App\Models\WeekContract;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWeekContractRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('week_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:week_contracts,id',
        ];
    }
}