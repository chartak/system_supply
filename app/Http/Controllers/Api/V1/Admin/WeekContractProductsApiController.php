<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWeekContractProductRequest;
use App\Http\Requests\UpdateWeekContractProductRequest;
use App\Http\Resources\Admin\WeekContractProductResource;
use App\Models\WeekContractProduct;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WeekContractProductsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('week_contract_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WeekContractProductResource(WeekContractProduct::with(['week_contract', 'year_con_prods'])->get());
    }

    public function store(StoreWeekContractProductRequest $request)
    {
        $weekContractProduct = WeekContractProduct::create($request->all());
        $weekContractProduct->year_con_prods()->sync($request->input('year_con_prods', []));

        return (new WeekContractProductResource($weekContractProduct))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WeekContractProductResource($weekContractProduct->load(['week_contract', 'year_con_prods']));
    }

    public function update(UpdateWeekContractProductRequest $request, WeekContractProduct $weekContractProduct)
    {
        $weekContractProduct->update($request->all());
        $weekContractProduct->year_con_prods()->sync($request->input('year_con_prods', []));

        return (new WeekContractProductResource($weekContractProduct))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WeekContractProduct $weekContractProduct)
    {
        abort_if(Gate::denies('week_contract_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContractProduct->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}