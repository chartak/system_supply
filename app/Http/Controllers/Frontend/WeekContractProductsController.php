<?php

namespace App\Http\Controllers\Frontend;

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

class WeekContractProductsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('week_contract_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContractProducts = WeekContractProduct::with(['week_contract', 'year_con_prods'])->get();

        return view('frontend.weekContractProducts.index', compact('weekContractProducts'));
    }

    public function create()
    {
        abort_if(Gate::denies('week_contract_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $week_contracts = WeekContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $year_con_prods = YearContractProduct::pluck('quantity', 'id');

        return view('frontend.weekContractProducts.create', compact('week_contracts', 'year_con_prods'));
    }

    public function store(StoreWeekContractProductRequest $request)
    {
        $weekContractProduct = WeekContractProduct::create($request->all());
        $weekContractProduct->year_con_prods()->sync($request->input('year_con_prods', []));

        return redirect()->route('frontend.week-contract-products.index');
    }

    public function edit(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $week_contracts = WeekContract::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $year_con_prods = YearContractProduct::pluck('quantity', 'id');

        $weekContractProduct->load('week_contract', 'year_con_prods');

        return view('frontend.weekContractProducts.edit', compact('weekContractProduct', 'week_contracts', 'year_con_prods'));
    }

    public function update(UpdateWeekContractProductRequest $request, WeekContractProduct $weekContractProduct)
    {
        $weekContractProduct->update($request->all());
        $weekContractProduct->year_con_prods()->sync($request->input('year_con_prods', []));

        return redirect()->route('frontend.week-contract-products.index');
    }

    public function show(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContractProduct->load('week_contract', 'year_con_prods');

        return view('frontend.weekContractProducts.show', compact('weekContractProduct'));
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