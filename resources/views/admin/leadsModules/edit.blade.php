@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.leadsModule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.leads-modules.update', $leadsModule->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ================= READONLY FIELDS (TOP SECTION) ================= --}}
            <div class="card shadow-sm p-4 mb-4">
                <h4 class="mb-3">Lead Information</h4>
                <div class="row">

                    {{-- NAME --}}
                    <div class="col-md-4 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.name') }}</label>
                        <input class="form-control" type="text" value="{{ $leadsModule->name }}" readonly>
                    </div>

                    {{-- MOBILE --}}
                    <div class="col-md-4 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.mobile') }}</label>
                        <input class="form-control" type="text" value="{{ $leadsModule->mobile }}" readonly>
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-4 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.email') }}</label>
                        <input class="form-control" type="text" value="{{ $leadsModule->email }}" readonly>
                    </div>

                    {{-- ASSIGNED TO --}}
                    <div class="col-md-4 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.assigned_to') }}</label>
                        <input class="form-control"
                               type="text"
                               value="{{ $assigned_tos[$leadsModule->assigned_to_id] ?? '' }}"
                               readonly>
                    </div>

                    {{-- SERVICE --}}
                    <div class="col-md-4 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.service') }}</label>
                        <input class="form-control"
                               type="text"
                               value="{{ $services[$leadsModule->service_id] ?? '' }}"
                               readonly>
                    </div>

                </div>
            </div>

            {{-- ================= EDITABLE FIELDS (BOTTOM SECTION) ================= --}}
            <div class="card shadow-sm p-4">
                <h4 class="mb-3">Update Lead Details</h4>

                <div class="row">

                    {{-- STATUS --}}
                    <div class="col-md-4 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.status') }}</label>
                        <select class="form-control" name="status" id="status">
                            <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\LeadsModule::STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ $leadsModule->status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- LAST CALL DATE --}}
                    <div class="col-md-4 mb-3">
                        <label for="last_call_date">{{ trans('cruds.leadsModule.fields.last_call_date') }}</label>
                        <input class="form-control datetime" type="text" name="last_call_date" value="{{ $leadsModule->last_call_date }}">
                    </div>

                    {{-- NOTES --}}
                    <div class="col-md-6 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.notes') }}</label>
                        <textarea class="form-control" name="notes" rows="3">{{ $leadsModule->notes }}</textarea>
                    </div>

                    {{-- REMARKS --}}
                    <div class="col-md-6 mb-3">
                        <label>{{ trans('cruds.leadsModule.fields.remarks_by_telecaller') }}</label>
                        <textarea class="form-control" name="remarks_by_telecaller" rows="3">{{ $leadsModule->remarks_by_telecaller }}</textarea>
                    </div>

                </div>
            </div>

            {{-- SAVE BUTTON --}}
            <div class="text-right mt-4">
                <button class="btn btn-danger">{{ trans('global.save') }}</button>
            </div>

        </form>
    </div>
</div>

@endsection
