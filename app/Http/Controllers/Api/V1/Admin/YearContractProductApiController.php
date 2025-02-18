<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYearContractProductRequest;
use App\Http\Requests\UpdateYearContractProductRequest;
use App\Http\Resources\Admin\YearContractProductResource;
use App\Models\YearContractProduct;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class YearContractProductApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('year_contract_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearContractProductResource(YearContractProduct::with(['year_contractid', 'productid'])->get());
    }

    public function store(StoreYearContractProductRequest $request)
    {
        $yearContractProduct = YearContractProduct::create($request->all());

        return (new YearContractProductResource($yearContractProduct))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearContractProductResource($yearContractProduct->load(['year_contractid', 'productid']));
    }

    public function update(UpdateYearContractProductRequest $request, YearContractProduct $yearContractProduct)
    {
        $yearContractProduct->update($request->all());

        return (new YearContractProductResource($yearContractProduct))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(YearContractProduct $yearContractProduct)
    {
        abort_if(Gate::denies('year_contract_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContractProduct->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}