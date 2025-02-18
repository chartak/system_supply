@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.weekContract.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.week-contracts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContract.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $weekContract->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContract.fields.year_contract') }}
                                    </th>
                                    <td>
                                        @foreach($weekContract->year_contracts as $key => $year_contract)
                                            <span class="label label-info">{{ $year_contract->start_date }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContract.fields.start_date') }}
                                    </th>
                                    <td>
                                        {{ $weekContract->start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContract.fields.end_date') }}
                                    </th>
                                    <td>
                                        {{ $weekContract->end_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContract.fields.wk_con_file') }}
                                    </th>
                                    <td>
                                        @foreach($weekContract->wk_con_file as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContract.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\WeekContract::STATUS_SELECT[$weekContract->status] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.week-contracts.index') }}">
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