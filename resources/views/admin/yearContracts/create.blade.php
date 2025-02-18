@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.yearContract.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.year-contracts.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="customerid_id">{{ trans('cruds.yearContract.fields.customerid') }}</label>
                    <select class="form-control select2 {{ $errors->has('customerid') ? 'is-invalid' : '' }}" name="customerid_id" id="customerid_id" required>
                        @foreach($customerids as $id => $entry)
                            <option value="{{ $id }}" {{ old('customerid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('customerid'))
                        <span class="text-danger">{{ $errors->first('customerid') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContract.fields.customerid_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="supplierid_id">{{ trans('cruds.yearContract.fields.supplierid') }}</label>
                    <select class="form-control select2 {{ $errors->has('supplierid') ? 'is-invalid' : '' }}" name="supplierid_id" id="supplierid_id" required>
                        @foreach($supplierids as $id => $entry)
                            <option value="{{ $id }}" {{ old('supplierid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('supplierid'))
                        <span class="text-danger">{{ $errors->first('supplierid') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContract.fields.supplierid_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="start_date">{{ trans('cruds.yearContract.fields.start_date') }}</label>
                    <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                    @if($errors->has('start_date'))
                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContract.fields.start_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="end_date">{{ trans('cruds.yearContract.fields.end_date') }}</label>
                    <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                    @if($errors->has('end_date'))
                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContract.fields.end_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="contract_doc">{{ trans('cruds.yearContract.fields.contract_doc') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('contract_doc') ? 'is-invalid' : '' }}" id="contract_doc-dropzone">
                    </div>
                    @if($errors->has('contract_doc'))
                        <span class="text-danger">{{ $errors->first('contract_doc') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContract.fields.contract_doc_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.yearContract.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\YearContract::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('status', 'new') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.yearContract.fields.status_helper') }}</span>
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

@section('scripts')
    <script>
        var uploadedContractDocMap = {}
        Dropzone.options.contractDocDropzone = {
            url: '{{ route('admin.year-contracts.storeMedia') }}',
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 5
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="contract_doc[]" value="' + response.name + '">')
                uploadedContractDocMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedContractDocMap[file.name]
                }
                $('form').find('input[name="contract_doc[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($yearContract) && $yearContract->contract_doc)
                var files =
                {!! json_encode($yearContract->contract_doc) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="contract_doc[]" value="' + file.file_name + '">')
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