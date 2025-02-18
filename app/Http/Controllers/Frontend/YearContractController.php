<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyYearContractRequest;
use App\Http\Requests\StoreYearContractRequest;
use App\Http\Requests\UpdateYearContractRequest;
use App\Models\UserInfo;
use App\Models\YearContract;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class YearContractController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('year_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContracts = YearContract::with(['customerid', 'supplierid', 'media'])->get();

        $user_infos = UserInfo::get();

        return view('frontend.yearContracts.index', compact('user_infos', 'yearContracts'));
    }

    public function create()
    {
        abort_if(Gate::denies('year_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerids = UserInfo::pluck('company', 'id')->prepend(trans('global.pleaseSelect'), '');

        $supplierids = UserInfo::pluck('company', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.yearContracts.create', compact('customerids', 'supplierids'));
    }

    public function store(StoreYearContractRequest $request)
    {
        $yearContract = YearContract::create($request->all());

        foreach ($request->input('contract_doc', []) as $file) {
            $yearContract->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('contract_doc');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $yearContract->id]);
        }

        return redirect()->route('frontend.year-contracts.index');
    }

    public function edit(YearContract $yearContract)
    {
        abort_if(Gate::denies('year_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerids = UserInfo::pluck('company', 'id')->prepend(trans('global.pleaseSelect'), '');

        $supplierids = UserInfo::pluck('company', 'id')->prepend(trans('global.pleaseSelect'), '');

        $yearContract->load('customerid', 'supplierid');

        return view('frontend.yearContracts.edit', compact('customerids', 'supplierids', 'yearContract'));
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

        return redirect()->route('frontend.year-contracts.index');
    }

    public function show(YearContract $yearContract)
    {
        abort_if(Gate::denies('year_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContract->load('customerid', 'supplierid', 'yearContractidYearContractProducts');

        return view('frontend.yearContracts.show', compact('yearContract'));
    }

    public function destroy(YearContract $yearContract)
    {
        abort_if(Gate::denies('year_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yearContract->delete();

        return back();
    }

    public function massDestroy(MassDestroyYearContractRequest $request)
    {
        $yearContracts = YearContract::find(request('ids'));

        foreach ($yearContracts as $yearContract) {
            $yearContract->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('year_contract_create') && Gate::denies('year_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new YearContract();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}