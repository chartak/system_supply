<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUnitMeasurementRequest;
use App\Http\Requests\StoreUnitMeasurementRequest;
use App\Http\Requests\UpdateUnitMeasurementRequest;
use App\Models\UnitMeasurement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitMeasurementController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_measurement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitMeasurements = UnitMeasurement::all();

        return view('frontend.unitMeasurements.index', compact('unitMeasurements'));
    }

    public function create()
    {
        abort_if(Gate::denies('unit_measurement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.unitMeasurements.create');
    }

    public function store(StoreUnitMeasurementRequest $request)
    {
        $unitMeasurement = UnitMeasurement::create($request->all());

        return redirect()->route('frontend.unit-measurements.index');
    }

    public function edit(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.unitMeasurements.edit', compact('unitMeasurement'));
    }

    public function update(UpdateUnitMeasurementRequest $request, UnitMeasurement $unitMeasurement)
    {
        $unitMeasurement->update($request->all());

        return redirect()->route('frontend.unit-measurements.index');
    }

    public function show(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.unitMeasurements.show', compact('unitMeasurement'));
    }

    public function destroy(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unitMeasurement->delete();

        return back();
    }

    public function massDestroy(MassDestroyUnitMeasurementRequest $request)
    {
        $unitMeasurements = UnitMeasurement::find(request('ids'));

        foreach ($unitMeasurements as $unitMeasurement) {
            $unitMeasurement->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}