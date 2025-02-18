@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.weekContract.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.week-contracts.update", [$weekContract->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="year_contracts">{{ trans('cruds.weekContract.fields.year_contract') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="year_contracts[]" id="year_contracts" multiple required>
                                @foreach($year_contracts as $id => $year_contract)
                                    <option value="{{ $id }}" {{ (in_array($id, old('year_contracts', [])) || $weekContract->year_contracts->contains($id)) ? 'selected' : '' }}>{{ $year_contract }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('year_contracts'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('year_contracts') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContract.fields.year_contract_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="start_date">{{ trans('cruds.weekContract.fields.start_date') }}</label>
                            <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date', $weekContract->start_date) }}" required>
                            @if($errors->has('start_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContract.fields.start_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="end_date">{{ trans('cruds.weekContract.fields.end_date') }}</label>
                            <input class="form-control date" type="text" name="end_date" id="end_date" value="{{ old('end_date', $weekContract->end_date) }}">
                            @if($errors->has('end_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContract.fields.end_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="wk_con_file">{{ trans('cruds.weekContract.fields.wk_con_file') }}</label>
                            <div class="needsclick dropzone" id="wk_con_file-dropzone">
                            </div>
                            @if($errors->has('wk_con_file'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wk_con_file') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContract.fields.wk_con_file_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.weekContract.fields.status') }}</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\WeekContract::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $weekContract->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.weekContract.fields.status_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedWkConFileMap = {}
Dropzone.options.wkConFileDropzone = {
    url: '{{ route('frontend.week-contracts.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="wk_con_file[]" value="' + response.name + '">')
      uploadedWkConFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedWkConFileMap[file.name]
      }
      $('form').find('input[name="wk_con_file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($weekContract) && $weekContract->wk_con_file)
          var files =
            {!! json_encode($weekContract->wk_con_file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="wk_con_file[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection