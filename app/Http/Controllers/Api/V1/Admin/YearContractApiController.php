<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreYearContractRequest;
use App\Http\Requests\UpdateYearContractRequest;
use App\Http\Resources\Admin\YearContractResource;
use App\Models\YearContract;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class YearContractApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('year_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearContractResource(YearContract::with(['customerid', 'supplierid'])->get());
    }

    public function store(StoreYearContractRequest $request)
    {
        $yearContract = YearContract::create($request->all());

        foreach ($request->input('contract_doc', []) as $file) {
            $yearContract->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('contract_doc');
        }

        return (new YearContractResource($yearContract))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(YearContract $yearContract)
    {
        abort_if(Gate::denies('year_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new YearContractResource($yearContract->load(['customerid', 'supplierid']));
    }

    public function update(UpdateYearContractRequest $request, YearContract $yearContract)
    {
        $yearContract->update($request->all());

        if (count($yearContract->contract_doc) > 0) {
            foreach ($yearContract->contract_doc as $media) {
                if (! in_array($media->file_name, $request->input('contract_doc', []))) {
                    $media->delete();
                }
            }
        }
        $media = $yearContract->contract_doc->pluck('file_name')->toArray();
        foreach ($request->input('contract_doc', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $yearContract->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('contract_doc');
            }
        }

        return (new YearContractResource($yearContract))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(YearContract $yearContract)
    {
        abort_if(Gate::denies('year_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContract->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}