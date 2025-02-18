<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\Admin\UserInfoResource;
use App\Models\UserInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserInfoApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserInfoResource(UserInfo::with(['userid'])->get());
    }

    public function store(StoreUserInfoRequest $request)
    {
        $userInfo = UserInfo::create($request->all());

        return (new UserInfoResource($userInfo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserInfoResource($userInfo->load(['userid']));
    }

    public function update(UpdateUserInfoRequest $request, UserInfo $userInfo)
    {
        $userInfo->update($request->all());

        return (new UserInfoResource($userInfo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserInfo $userInfo)
    {
        abort_if(Gate::denies('user_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userInfo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}