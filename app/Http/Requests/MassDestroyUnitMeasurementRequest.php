<?php

namespace App\Http\Requests;

use App\Models\UnitMeasurement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUnitMeasurementRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('unit_measurement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:unit_measurements,id',
        ];
    }
}