@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.products.update", [$product->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="cpv">{{ trans('cruds.product.fields.cpv') }}</label>
                                <input class="form-control" type="number" name="cpv" id="cpv" value="{{ old('cpv', $product->cpv) }}" step="1" required>
                                @if($errors->has('cpv'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('cpv') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.product.fields.cpv_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="unit_measurementid_id">{{ trans('cruds.product.fields.unit_measurementid') }}</label>
                                <select class="form-control select2" name="unit_measurementid_id" id="unit_measurementid_id" required>
                                    @foreach($unit_measurementids as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('unit_measurementid_id') ? old('unit_measurementid_id') : $product->unit_measurementid->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('unit_measurementid'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('unit_measurementid') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.product.fields.unit_measurementid_helper') }}</span>
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