@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.yearContractProduct.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.year-contract-products.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.id') }}
                        </th>
                        <td>
                            {{ $yearContractProduct->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.year_contractid') }}
                        </th>
                        <td>
                            {{ $yearContractProduct->year_contractid->start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.productid') }}
                        </th>
                        <td>
                            {{ $yearContractProduct->productid->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.quantity') }}
                        </th>
                        <td>
                            {{ $yearContractProduct->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.price') }}
                        </th>
                        <td>
                            {{ $yearContractProduct->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearContractProduct.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\YearContractProduct::TYPE_SELECT[$yearContractProduct->type] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.year-contract-products.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection