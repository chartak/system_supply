<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserInfoRequest;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\User;
use App\Models\UserInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserInfoController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserInfo::with(['userid'])->select(sprintf('%s.*', (new UserInfo)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_info_show';
                $editGate      = 'user_info_edit';
                $deleteGate    = 'user_info_delete';
                $crudRoutePart = 'user-infos';

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
            $table->addColumn('userid_name', function ($row) {
                return $row->userid ? $row->userid->name : '';
            });

            $table->editColumn('company', function ($row) {
                return $row->company ? $row->company : '';
            });
            $table->editColumn('company_email', function ($row) {
                return $row->company_email ? $row->company_email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('bank_name', function ($row) {
                return $row->bank_name ? $row->bank_name : '';
            });
            $table->editColumn('bank_account_number', function ($row) {
                return $row->bank_account_number ? $row->bank_account_number : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? UserInfo::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('tax_code', function ($row) {
                return $row->tax_code ? $row->tax_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'userid']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.userInfos.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_info_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userids = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userInfos.create', compact('userids'));
    }

    public function store(StoreUserInfoRequest $request)
    {
        $userInfo = UserInfo::create($request->all());

        return redirect()->route('admin.user-infos.index');
    }

    public function edit(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userids = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userInfo->load('userid');

        return view('admin.userInfos.edit', compact('userInfo', 'userids'));
    }

    public function update(UpdateUserInfoRequest $request, UserInfo $userInfo)
    {
        $userInfo->update($request->all());

        return redirect()->route('admin.user-infos.index');
    }

    public function show(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userInfo->load('userid');

        return view('admin.userInfos.show', compact('userInfo'));
    }

    public function destroy(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userInfo->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserInfoRequest $request)
    {
        $userInfos = UserInfo::find(request('ids'));

        foreach ($userInfos as $userInfo) {
            $userInfo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}