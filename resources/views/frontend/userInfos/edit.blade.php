@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.userInfo.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.user-infos.update", [$userInfo->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label class="required" for="userid_id">{{ trans('cruds.userInfo.fields.userid') }}</label>
                                <select class="form-control select2" name="userid_id" id="userid_id" required>
                                    @foreach($userids as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('userid_id') ? old('userid_id') : $userInfo->userid->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('userid'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('userid') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.userid_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="company">{{ trans('cruds.userInfo.fields.company') }}</label>
                                <input class="form-control" type="text" name="company" id="company" value="{{ old('company', $userInfo->company) }}" required>
                                @if($errors->has('company'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('company') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.company_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="company_email">{{ trans('cruds.userInfo.fields.company_email') }}</label>
                                <input class="form-control" type="email" name="company_email" id="company_email" value="{{ old('company_email', $userInfo->company_email) }}" required>
                                @if($errors->has('company_email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('company_email') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.company_email_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="phone">{{ trans('cruds.userInfo.fields.phone') }}</label>
                                <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $userInfo->phone) }}" required>
                                @if($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.phone_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="address">{{ trans('cruds.userInfo.fields.address') }}</label>
                                <input class="form-control" type="text" name="address" id="address" value="{{ old('address', $userInfo->address) }}" required>
                                @if($errors->has('address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.address_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="bank_name">{{ trans('cruds.userInfo.fields.bank_name') }}</label>
                                <input class="form-control" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $userInfo->bank_name) }}" required>
                                @if($errors->has('bank_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bank_name') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.bank_name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="bank_account_number">{{ trans('cruds.userInfo.fields.bank_account_number') }}</label>
                                <input class="form-control" type="number" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', $userInfo->bank_account_number) }}" step="1" required>
                                @if($errors->has('bank_account_number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bank_account_number') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.bank_account_number_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required">{{ trans('cruds.userInfo.fields.type') }}</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                    @foreach(App\Models\UserInfo::TYPE_SELECT as $key => $label)
                                        <option value="{{ $key }}" {{ old('type', $userInfo->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('type'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('type') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.type_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="tax_code">{{ trans('cruds.userInfo.fields.tax_code') }}</label>
                                <input class="form-control" type="text" name="tax_code" id="tax_code" value="{{ old('tax_code', $userInfo->tax_code) }}">
                                @if($errors->has('tax_code'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tax_code') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.userInfo.fields.tax_code_helper') }}</span>
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