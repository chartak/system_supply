<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyYearContractProductRequest;
use App\Http\Requests\StoreYearContractProductRequest;
use App\Http\Requests\UpdateYearContractProductRequest;
use App\Models\Product;
use App\Models\YearContract;
use App\Models\YearContractProduct;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class YearContractProductController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('year_contract_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = YearContractProduct::with(['year_contractid', 'productid'])->select(sprintf('%s.*', (new YearContractProduct)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'year_contract_product_show';
                $editGate      = 'year_contract_product_edit';
                $deleteGate    = 'year_contract_product_delete';
                $crudRoutePart = 'year-contract-products';

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
            $table->addColumn('year_contractid_start_date', function ($row) {
                return $row->year_contractid ? $row->year_contractid->start_date : '';
            });

            $table->editColumn('year_contractid.end_date', function ($row) {
                return $row->year_contractid ? (is_string($row->year_contractid) ? $row->year_contractid : $row->year_contractid->end_date) : '';
            });
            $table->editColumn('year_contractid.status', function ($row) {
                return $row->year_contractid ? (is_string($row->year_contractid) ? $row->year_contractid : $row->year_contractid->status) : '';
            });
            $table->addColumn('productid_name', function ($row) {
                return $row->productid ? $row->productid->name : '';
            });

            $table->editColumn('quantity', function ($row) {
                return $row->quantity ? $row->quantity : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? YearContractProduct::TYPE_SELECT[$row->type] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'year_contractid', 'productid']);

            return $table->make(true);
        }

        $year_contracts = YearContract::get();
        $products       = Product::get();

        return view('admin.yearContractProducts.index', compact('year_contracts', 'products'));
    }

    public function create()
    {
        abort_if(Gate::denies('year_contract_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contractids = YearContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productids = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.yearContractProducts.create', compact('productids', 'year_contractids'));
    }

    public function store(StoreYearContractProductRequest $request)
    {
        $yearContractProduct = YearContractProduct::create($request->all());

        return redirect()->route('admin.year-contract-products.index');
    }

    public function edit(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contractids = YearContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productids = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $yearContractProduct->load('year_contractid', 'productid');

        return view('admin.yearContractProducts.edit', compact('productids', 'yearContractProduct', 'year_contractids'));
    }

    public function update(UpdateYearContractProductRequest $request, YearContractProduct $yearContractProduct)
    {
        $yearContractProduct->update($request->all());

        return redirect()->route('admin.year-contract-products.index');
    }

    public function show(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContractProduct->load('year_contractid', 'productid');

        return view('admin.yearContractProducts.show', compact('yearContractProduct'));
    }

    public function destroy(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContractProduct->delete();

        return back();
    }

    public function massDestroy(MassDestroyYearContractProductRequest $request)
    {
        $yearContractProducts = YearContractProduct::find(request('ids'));

        foreach ($yearContractProducts as $yearContractProduct) {
            $yearContractProduct->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}