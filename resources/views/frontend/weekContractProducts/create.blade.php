@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.weekContractProduct.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.week-contract-products.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="week_contract_id">{{ trans('cruds.weekContractProduct.fields.week_contract') }}</label>
                            <select class="form-control select2" name="week_contract_id" id="week_contract_id" required>
                                @foreach($week_contracts as $id => $entry)
                                    <option value="{{ $id }}" {{ old('week_contract_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('week_contract'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('week_contract') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContractProduct.fields.week_contract_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="quantity">{{ trans('cruds.weekContractProduct.fields.quantity') }}</label>
                            <input class="form-control" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="0.01" required>
                            @if($errors->has('quantity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('quantity') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContractProduct.fields.quantity_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="year_con_prods">{{ trans('cruds.weekContractProduct.fields.year_con_prod') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="year_con_prods[]" id="year_con_prods" multiple required>
                                @foreach($year_con_prods as $id => $year_con_prod)
                                    <option value="{{ $id }}" {{ in_array($id, old('year_con_prods', [])) ? 'selected' : '' }}>{{ $year_con_prod }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('year_con_prods'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('year_con_prods') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContractProduct.fields.year_con_prod_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.weekContractProduct.fields.type') }}</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\WeekContractProduct::TYPE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContractProduct.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection