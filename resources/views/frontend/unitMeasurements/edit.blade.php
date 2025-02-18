@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.unitMeasurement.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.unit-measurements.update", [$unitMeasurement->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="unit_of_measurement">{{ trans('cruds.unitMeasurement.fields.unit_of_measurement') }}</label>
                                <input class="form-control" type="text" name="unit_of_measurement" id="unit_of_measurement" value="{{ old('unit_of_measurement', $unitMeasurement->unit_of_measurement) }}" required>
                                @if($errors->has('unit_of_measurement'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('unit_of_measurement') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.unitMeasurement.fields.unit_of_measurement_helper') }}</span>
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