@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.yearContract.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.year-contracts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.id') }}
                        </th>
                        <td>
                            {{ $yearContract->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.customerid') }}
                        </th>
                        <td>
                            {{ $yearContract->customerid->company ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.supplierid') }}
                        </th>
                        <td>
                            {{ $yearContract->supplierid->company ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.start_date') }}
                        </th>
                        <td>
                            {{ $yearContract->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.end_date') }}
                        </th>
                        <td>
                            {{ $yearContract->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.contract_doc') }}
                        </th>
                        <td>
                            @foreach($yearContract->contract_doc as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContract.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\YearContract::STATUS_SELECT[$yearContract->status] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.year-contracts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#year_contractid_year_contract_products" role="tab" data-toggle="tab">
                    {{ trans('cruds.yearContractProduct.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="year_contractid_year_contract_products">
                @includeIf('admin.yearContracts.relationships.yearContractidYearContractProducts', ['yearContractProducts' => $yearContract->yearContractidYearContractProducts])
            </div>
        </div>
    </div>

@endsection