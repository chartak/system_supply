<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUnitMeasurementRequest;
use App\Http\Requests\StoreUnitMeasurementRequest;
use App\Http\Requests\UpdateUnitMeasurementRequest;
use App\Models\UnitMeasurement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UnitMeasurementController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('unit_measurement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UnitMeasurement::query()->select(sprintf('%s.*', (new UnitMeasurement)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'unit_measurement_show';
                $editGate      = 'unit_measurement_edit';
                $deleteGate    = 'unit_measurement_delete';
                $crudRoutePart = 'unit-measurements';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('unit_of_measurement', function ($row) {
                return $row->unit_of_measurement ? $row->unit_of_measurement : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.unitMeasurements.index');
    }

    public function create()
    {
        abort_if(Gate::denies('unit_measurement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitMeasurements.create');
    }

    public function store(StoreUnitMeasurementRequest $request)
    {
        $unitMeasurement = UnitMeasurement::create($request->all());

        return redirect()->route('admin.unit-measurements.index');
    }

    public function edit(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitMeasurements.edit', compact('unitMeasurement'));
    }

    public function update(UpdateUnitMeasurementRequest $request, UnitMeasurement $unitMeasurement)
    {
        $unitMeasurement->update($request->all());

        return redirect()->route('admin.unit-measurements.index');
    }

    public function show(UnitMeasurement $unitMeasurement)
    {
        abort_if(Gate::denies('unit_measurement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.unitMeasurements.show', compact('unitMeasurement'));
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