@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.yearContractProduct.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.year-contract-products.update", [$yearContractProduct->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="year_contractid_id">{{ trans('cruds.yearContractProduct.fields.year_contractid') }}</label>
                                <select class="form-control select2" name="year_contractid_id" id="year_contractid_id" required>
                                    @foreach($year_contractids as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('year_contractid_id') ? old('year_contractid_id') : $yearContractProduct->year_contractid->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('year_contractid'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('year_contractid') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.yearContractProduct.fields.year_contractid_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="productid_id">{{ trans('cruds.yearContractProduct.fields.productid') }}</label>
                                <select class="form-control select2" name="productid_id" id="productid_id" required>
                                    @foreach($productids as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('productid_id') ? old('productid_id') : $yearContractProduct->productid->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('productid'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('productid') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.yearContractProduct.fields.productid_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="quantity">{{ trans('cruds.yearContractProduct.fields.quantity') }}</label>
                                <input class="form-control" type="number" name="quantity" id="quantity" value="{{ old('quantity', $yearContractProduct->quantity) }}" step="1" required>
                                @if($errors->has('quantity'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('quantity') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.yearContractProduct.fields.quantity_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="price">{{ trans('cruds.yearContractProduct.fields.price') }}</label>
                                <input class="form-control" type="number" name="price" id="price" value="{{ old('price', $yearContractProduct->price) }}" step="0.01" required>
                                @if($errors->has('price'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('price') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.yearContractProduct.fields.price_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required">{{ trans('cruds.yearContractProduct.fields.type') }}</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach(App\Models\YearContractProduct::TYPE_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('type', $yearContractProduct->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('type'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('type') }}
                                    </div>
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

            </div>
        </div>
    </div>
@endsection