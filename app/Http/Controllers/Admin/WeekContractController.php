<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class WeekContractController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('week_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WeekContract::with(['year_contracts'])->select(sprintf('%s.*', (new WeekContract)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'week_contract_show';
                $editGate      = 'week_contract_edit';
                $deleteGate    = 'week_contract_delete';
                $crudRoutePart = 'week-contracts';

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
            $table->editColumn('year_contract', function ($row) {
                $labels = [];
                foreach ($row->year_contracts as $year_contract) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $year_contract->start_date);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('wk_con_file', function ($row) {
                if (! $row->wk_con_file) {
                    return '';
                }
                $links = [];
                foreach ($row->wk_con_file as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? WeekContract::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'year_contract', 'wk_con_file']);

            return $table->make(true);
        }

        return view('admin.weekContracts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('week_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contracts = YearContract::pluck('start_date', 'id');

        return view('admin.weekContracts.create', compact('year_contracts'));
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

        return redirect()->route('admin.week-contracts.index');
    }

    public function edit(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year_contracts = YearContract::pluck('start_date', 'id');

        $weekContract->load('year_contracts');

        return view('admin.weekContracts.edit', compact('weekContract', 'year_contracts'));
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

        return redirect()->route('admin.week-contracts.index');
    }

    public function show(WeekContract $weekContract)
    {
        abort_if(Gate::denies('week_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekContract->load('year_contracts');

        return view('admin.weekContracts.show', compact('weekContract'));
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