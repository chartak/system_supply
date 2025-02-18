@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.userInfo.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.user-infos.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.userid') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->userid->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->company }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.company_email') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->company_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.phone') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.address') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.bank_name') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->bank_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.bank_account_number') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->bank_account_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\UserInfo::TYPE_SELECT[$userInfo->type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userInfo.fields.tax_code') }}
                                    </th>
                                    <td>
                                        {{ $userInfo->tax_code }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.user-infos.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection