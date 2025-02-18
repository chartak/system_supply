<?php

namespace App\Http\Controllers\Frontend;

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

class YearContractProductController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('year_contract_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContractProducts = YearContractProduct::with(['year_contractid', 'productid'])->get();

        $year_contracts = YearContract::get();

        $products = Product::get();

        return view('frontend.yearContractProducts.index', compact('products', 'yearContractProducts', 'year_contracts'));
    }

    public function create()
    {
        abort_if(Gate::denies('year_contract_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contractids = YearContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productids = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.yearContractProducts.create', compact('productids', 'year_contractids'));
    }

    public function store(StoreYearContractProductRequest $request)
    {
        $yearContractProduct = YearContractProduct::create($request->all());

        return redirect()->route('frontend.year-contract-products.index');
    }

    public function edit(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contractids = YearContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productids = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $yearContractProduct->load('year_contractid', 'productid');

        return view('frontend.yearContractProducts.edit', compact('productids', 'yearContractProduct', 'year_contractids'));
    }

    public function update(UpdateYearContractProductRequest $request, YearContractProduct $yearContractProduct)
    {
        $yearContractProduct->update($request->all());

        return redirect()->route('frontend.year-contract-products.index');
    }

    public function show(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContractProduct->load('year_contractid', 'productid');

        return view('frontend.yearContractProducts.show', compact('yearContractProduct'));
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