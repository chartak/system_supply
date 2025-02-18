<?php

namespace App\Http\Requests;

use App\Models\UnitMeasurement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUnitMeasurementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('unit_measurement_create');
    }

    public function rules()
    {
        return [
            'unit_of_measurement' => [
                'string',
                'min:2',
                'max:20',
                'required',
            ],
        ];
    }
}