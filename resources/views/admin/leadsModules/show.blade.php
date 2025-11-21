@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.leadsModule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leads-modules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.id') }}
                        </th>
                        <td>
                            {{ $leadsModule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.name') }}
                        </th>
                        <td>
                            {{ $leadsModule->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.mobile') }}
                        </th>
                        <td>
                            {{ $leadsModule->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.email') }}
                        </th>
                        <td>
                            {{ $leadsModule->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\LeadsModule::STATUS_SELECT[$leadsModule->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.assigned_to') }}
                        </th>
                        <td>
                            {{ $leadsModule->assigned_to->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.notes') }}
                        </th>
                        <td>
                            {{ $leadsModule->notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.remarks_by_telecaller') }}
                        </th>
                        <td>
                            {{ $leadsModule->remarks_by_telecaller }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.last_call_date') }}
                        </th>
                        <td>
                            {{ $leadsModule->last_call_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leadsModule.fields.service') }}
                        </th>
                        <td>
                            {{ $leadsModule->service->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leads-modules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection