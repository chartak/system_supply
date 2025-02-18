<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWeekContractProductRequest;
use App\Http\Requests\StoreWeekContractProductRequest;
use App\Http\Requests\UpdateWeekContractProductRequest;
use App\Models\WeekContract;
use App\Models\WeekContractProduct;
use App\Models\YearContractProduct;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WeekContractProductsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('week_contract_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WeekContractProduct::with(['week_contract', 'year_con_prods'])->select(sprintf('%s.*', (new WeekContractProduct)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'week_contract_product_show';
                $editGate      = 'week_contract_product_edit';
                $deleteGate    = 'week_contract_product_delete';
                $crudRoutePart = 'week-contract-products';

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
            $table->addColumn('week_contract_start_date', function ($row) {
                return $row->week_contract ? $row->week_contract->start_date : '';
            });

            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('year_con_prod', function ($row) {
                $labels = [];
                foreach ($row->year_con_prods as $year_con_prod) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $year_con_prod->quantity);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? WeekContractProduct::TYPE_SELECT[$row->type] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'week_contract', 'year_con_prod']);

            return $table->make(true);
        }

        return view('admin.weekContractProducts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('week_contract_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $week_contracts = WeekContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $year_con_prods = YearContractProduct::pluck('quantity', 'id');

        return view('admin.weekContractProducts.create', compact('week_contracts', 'year_con_prods'));
    }

    public function store(StoreWeekContractProductRequest $request)
    {
        $weekContractProduct = WeekContractProduct::create($request->all());
        $weekContractProduct->year_con_prods()->sync($request->input('year_con_prods', []));

        return redirect()->route('admin.week-contract-products.index');
    }

    public function edit(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $week_contracts = WeekContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $year_con_prods = YearContractProduct::pluck('quantity', 'id');

        $weekContractProduct->load('week_contract', 'year_con_prods');

        return view('admin.weekContractProducts.edit', compact('weekContractProduct', 'week_contracts', 'year_con_prods'));
    }

    public function update(UpdateWeekContractProductRequest $request, WeekContractProduct $weekContractProduct)
    {
        $weekContractProduct->update($request->all());
        $weekContractProduct->year_con_prods()->sync($request->input('year_con_prods', []));

        return redirect()->route('admin.week-contract-products.index');
    }

    public function show(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContractProduct->load('week_contract', 'year_con_prods');

        return view('admin.weekContractProducts.show', compact('weekContractProduct'));
    }

    public function destroy(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContractProduct->delete();

        return back();
    }

    public function massDestroy(MassDestroyWeekContractProductRequest $request)
    {
        $weekContractProducts = WeekContractProduct::find(request('ids'));

        foreach ($weekContractProducts as $weekContractProduct) {
            $weekContractProduct->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}