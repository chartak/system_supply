@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.weekContractProduct.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.week-contract-products.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $weekContractProduct->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.week_contract') }}
                                    </th>
                                    <td>
                                        {{ $weekContractProduct->week_contract->start_date ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.quantity') }}
                                    </th>
                                    <td>
                                        {{ $weekContractProduct->quantity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.year_con_prod') }}
                                    </th>
                                    <td>
                                        @foreach($weekContractProduct->year_con_prods as $key => $year_con_prod)
                                            <span class="label label-info">{{ $year_con_prod->quantity }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.weekContractProduct.fields.type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\WeekContractProduct::TYPE_SELECT[$weekContractProduct->type] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.week-contract-products.index') }}">
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