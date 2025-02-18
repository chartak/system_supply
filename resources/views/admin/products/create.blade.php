@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.products.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="cpv">{{ trans('cruds.product.fields.cpv') }}</label>
                    <input class="form-control {{ $errors->has('cpv') ? 'is-invalid' : '' }}" type="text" name="cpv" id="cpv" value="{{ old('cpv', '') }}" required>
                    @if($errors->has('cpv'))
                        <span class="text-danger">{{ $errors->first('cpv') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.cpv_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="unit_measurementid_id">{{ trans('cruds.product.fields.unit_measurementid') }}</label>
                    <select class="form-control select2 {{ $errors->has('unit_measurementid') ? 'is-invalid' : '' }}" name="unit_measurementid_id" id="unit_measurementid_id" required>
                        @foreach($unit_measurementids as $id => $entry)
                            <option value="{{ $id }}" {{ old('unit_measurementid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('unit_measurementid'))
                        <span class="text-danger">{{ $errors->first('unit_measurementid') }}</span>
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



@endsection