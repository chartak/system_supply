<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWeekContractRequest;
use App\Http\Requests\UpdateWeekContractRequest;
use App\Http\Resources\Admin\WeekContractResource;
use App\Models\WeekContract;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WeekContractApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('week_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WeekContractResource(WeekContract::with(['year_contracts'])->get());
    }

    public function store(StoreWeekContractRequest $request)
    {
        $weekContract = WeekContract::create($request->all());
        $weekContract->year_contracts()->sync($request->input('year_contracts', []));
        foreach ($request->input('wk_con_file', []) as $file) {
            $weekContract->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('wk_con_file');
        }

        return (new WeekContractResource($weekContract))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WeekContractResource($weekContract->load(['year_contracts']));
    }

    public function update(UpdateWeekContractRequest $request, WeekContract $weekContract)
    {
        $weekContract->update($request->all());
        $weekContract->year_contracts()->sync($request->input('year_contracts', []));
        if (count($weekContract->wk_con_file) > 0) {
            foreach ($weekContract->wk_con_file as $media) {
                if (! in_array($media->file_name, $request->input('wk_con_file', []))) {
                    $media->delete();
                }
            }
        }
        $media = $weekContract->wk_con_file->pluck('file_name')->toArray();
        foreach ($request->input('wk_con_file', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $weekContract->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('wk_con_file');
            }
        }

        return (new WeekContractResource($weekContract))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContract->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}