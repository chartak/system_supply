<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRewrewrRequest;
use App\Http\Requests\StoreRewrewrRequest;
use App\Http\Requests\UpdateRewrewrRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RewrewrController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rewrewr_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rewrewrs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('rewrewr_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rewrewrs.create');
    }

    public function store(StoreRewrewrRequest $request)
    {
        $rewrewr = Rewrewr::create($request->all());

        return redirect()->route('admin.rewrewrs.index');
    }

    public function edit(Rewrewr $rewrewr)
    {
        abort_if(Gate::denies('rewrewr_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rewrewrs.edit', compact('rewrewr'));
    }

    public function update(UpdateRewrewrRequest $request, Rewrewr $rewrewr)
    {
        $rewrewr->update($request->all());

        return redirect()->route('admin.rewrewrs.index');
    }

    public function show(Rewrewr $rewrewr)
    {
        abort_if(Gate::denies('rewrewr_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rewrewrs.show', compact('rewrewr'));
    }

    public function destroy(Rewrewr $rewrewr)
    {
        abort_if(Gate::denies('rewrewr_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rewrewr->delete();

        return back();
    }

    public function massDestroy(MassDestroyRewrewrRequest $request)
    {
        $rewrewrs = Rewrewr::find(request('ids'));

        foreach ($rewrewrs as $rewrewr) {
            $rewrewr->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}