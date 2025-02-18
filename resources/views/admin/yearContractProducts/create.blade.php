@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.yearContractProduct.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.year-contract-products.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="year_contractid_id">{{ trans('cruds.yearContractProduct.fields.year_contractid') }}</label>
                    <select class="form-control select2 {{ $errors->has('year_contractid') ? 'is-invalid' : '' }}" name="year_contractid_id" id="year_contractid_id" required>
                        @foreach($year_contractids as $id => $entry)
                            <option value="{{ $id }}" {{ old('year_contractid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('year_contractid'))
                        <span class="text-danger">{{ $errors->first('year_contractid') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContractProduct.fields.year_contractid_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="productid_id">{{ trans('cruds.yearContractProduct.fields.productid') }}</label>
                    <select class="form-control select2 {{ $errors->has('productid') ? 'is-invalid' : '' }}" name="productid_id" id="productid_id" required>
                        @foreach($productids as $id => $entry)
                            <option value="{{ $id }}" {{ old('productid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('productid'))
                        <span class="text-danger">{{ $errors->first('productid') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContractProduct.fields.productid_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="quantity">{{ trans('cruds.yearContractProduct.fields.quantity') }}</label>
                    <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="1" required>
                    @if($errors->has('quantity'))
                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContractProduct.fields.quantity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="price">{{ trans('cruds.yearContractProduct.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01" required>
                    @if($errors->has('price'))
                        <span class="text-danger">{{ $errors->first('price') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContractProduct.fields.price_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.yearContractProduct.fields.type') }}</label>
                    <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                        <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\YearContractProduct::TYPE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContractProduct.fields.type_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection