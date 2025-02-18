<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitMeasurementRequest;
use App\Http\Requests\UpdateUnitMeasurementRequest;
use App\Http\Resources\Admin\UnitMeasurementResource;
use App\Models\UnitMeasurement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitMeasurementApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_measurement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitMeasurementResource(UnitMeasurement::all());
    }

    public function store(StoreUnitMeasurementRequest $request)
    {
        $unitMeasurement = UnitMeasurement::create($request->all());

        return (new UnitMeasurementResource($unitMeasurement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UnitMeasurementResource($unitMeasurement);
    }

    public function update(UpdateUnitMeasurementRequest $request, UnitMeasurement $unitMeasurement)
    {
        $unitMeasurement->update($request->all());

        return (new UnitMeasurementResource($unitMeasurement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitMeasurement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}