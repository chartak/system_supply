<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWeekContractRequest;
use App\Http\Requests\StoreWeekContractRequest;
use App\Http\Requests\UpdateWeekContractRequest;
use App\Models\WeekContract;
use App\Models\YearContract;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class WeekContractController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('week_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContracts = WeekContract::with(['year_contracts', 'media'])->get();

        return view('frontend.weekContracts.index', compact('weekContracts'));
    }

    public function create()
    {
        abort_if(Gate::denies('week_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contracts = YearContract::pluck('start_date', 'id');

        return view('frontend.weekContracts.create', compact('year_contracts'));
    }

    public function store(StoreWeekContractRequest $request)
    {
        $weekContract = WeekContract::create($request->all());
        $weekContract->year_contracts()->sync($request->input('year_contracts', []));
        foreach ($request->input('wk_con_file', []) as $file) {
            $weekContract->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('wk_con_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $weekContract->id]);
        }

        return redirect()->route('frontend.week-contracts.index');
    }

    public function edit(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contracts = YearContract::pluck('start_date', 'id');

        $weekContract->load('year_contracts');

        return view('frontend.weekContracts.edit', compact('weekContract', 'year_contracts'));
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

        return redirect()->route('frontend.week-contracts.index');
    }

    public function show(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContract->load('year_contracts');

        return view('frontend.weekContracts.show', compact('weekContract'));
    }

    public function destroy(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContract->delete();

        return back();
    }

    public function massDestroy(MassDestroyWeekContractRequest $request)
    {
        $weekContracts = WeekContract::find(request('ids'));

        foreach ($weekContracts as $weekContract) {
            $weekContract->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('week_contract_create') && Gate::denies('week_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new WeekContract();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}