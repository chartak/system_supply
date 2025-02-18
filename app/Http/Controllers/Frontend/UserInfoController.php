<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserInfoRequest;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\User;
use App\Models\UserInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserInfoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userInfos = UserInfo::with(['userid'])->get();

        $users = User::get();

        return view('frontend.userInfos.index', compact('userInfos', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_info_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userids = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.userInfos.create', compact('userids'));
    }

    public function store(StoreUserInfoRequest $request)
    {
        $userInfo = UserInfo::create($request->all());

        return redirect()->route('frontend.user-infos.index');
    }

    public function edit(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userids = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userInfo->load('userid');

        return view('frontend.userInfos.edit', compact('userInfo', 'userids'));
    }

    public function update(UpdateUserInfoRequest $request, UserInfo $userInfo)
    {
        $userInfo->update($request->all());

        return redirect()->route('frontend.user-infos.index');
    }

    public function show(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userInfo->load('userid');

        return view('frontend.userInfos.show', compact('userInfo'));
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