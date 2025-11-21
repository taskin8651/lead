@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.leadsModule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leads-modules.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.leadsModule.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mobile">{{ trans('cruds.leadsModule.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', '') }}">
                @if($errors->has('mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.leadsModule.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.leadsModule.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\LeadsModule::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'New') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="assigned_to_id">{{ trans('cruds.leadsModule.fields.assigned_to') }}</label>
                <select class="form-control select2 {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}" name="assigned_to_id" id="assigned_to_id">
                    @foreach($assigned_tos as $id => $entry)
                        <option value="{{ $id }}" {{ old('assigned_to_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('assigned_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('assigned_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.assigned_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.leadsModule.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes') }}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks_by_telecaller">{{ trans('cruds.leadsModule.fields.remarks_by_telecaller') }}</label>
                <textarea class="form-control {{ $errors->has('remarks_by_telecaller') ? 'is-invalid' : '' }}" name="remarks_by_telecaller" id="remarks_by_telecaller">{{ old('remarks_by_telecaller') }}</textarea>
                @if($errors->has('remarks_by_telecaller'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks_by_telecaller') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.remarks_by_telecaller_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_call_date">{{ trans('cruds.leadsModule.fields.last_call_date') }}</label>
                <input class="form-control datetime {{ $errors->has('last_call_date') ? 'is-invalid' : '' }}" type="text" name="last_call_date" id="last_call_date" value="{{ old('last_call_date') }}">
                @if($errors->has('last_call_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_call_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.last_call_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="service_id">{{ trans('cruds.leadsModule.fields.service') }}</label>
                <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}" name="service_id" id="service_id">
                    @foreach($services as $id => $entry)
                        <option value="{{ $id }}" {{ old('service_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leadsModule.fields.service_helper') }}</span>
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