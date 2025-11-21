@extends('layouts.admin')
@section('content')
@can('leads_module_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.leads-modules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.leadsModule.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'LeadsModule', 'route' => 'admin.leads-modules.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
    {{ trans('cruds.leadsModule.title_singular') }} {{ trans('global.list') }}
</div>

{{-- 🔽 FILTER SECTION --}}
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <form id="filterForm" method="GET" class="row g-3 align-items-end">

            {{-- QUICK DATE FILTER --}}
            <div class="col-md-2">
                <label class="form-label">Quick Filter</label>
                <select name="filter_type" id="filter_type" class="form-control">
                    <option value="">-- Select --</option>
                    <option value="today" {{ request('filter_type') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('filter_type') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="7_days" {{ request('filter_type') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="15_days" {{ request('filter_type') == '15_days' ? 'selected' : '' }}>Last 15 Days</option>
                    <option value="1_month" {{ request('filter_type') == '1_month' ? 'selected' : '' }}>Last 1 Month</option>
                    <option value="custom" {{ request('filter_type') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            {{-- FROM DATE --}}
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control"
                    value="{{ request('from_date') }}">
            </div>

            {{-- TO DATE --}}
            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control"
                    value="{{ request('to_date') }}">
            </div>

            {{-- STATUS FILTER --}}
            <div class="col-md-2">
                <label class="form-label">Lead Status</label>
                <select name="status" class="form-control">
                    <option value="">-- All --</option>
                    @foreach(App\Models\LeadsModule::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SUBMIT --}}
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Apply</button>
            </div>

            {{-- RESET --}}
            <div class="col-md-1">
                <a href="{{ route('admin.leads-modules.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>

        </form>
    </div>
</div>

{{-- 🔽 FILTER SUMMARY --}}
@if(request()->anyFilled(['filter_type','status','from_date','to_date']))
    <div class="alert alert-info py-2 mb-3">
        <strong>Filter Applied:</strong>

        @if(request('filter_type'))
            {{ ucfirst(str_replace('_',' ', request('filter_type'))) }}
        @endif

        @if(request('from_date') && request('to_date'))
            ({{ request('from_date') }} - {{ request('to_date') }})
        @endif

        @if(request('status'))
            — Status: <strong>{{ App\Models\LeadsModule::STATUS_SELECT[request('status')] }}</strong>
        @endif

        — Showing <strong>{{ $leadsModules->count() }}</strong> records
    </div>
@endif


    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LeadsModule">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.assigned_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.notes') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.remarks_by_telecaller') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.last_call_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.leadsModule.fields.service') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leadsModules as $key => $leadsModule)
                        <tr data-entry-id="{{ $leadsModule->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $leadsModule->id ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->name ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->email ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\LeadsModule::STATUS_SELECT[$leadsModule->status] ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->assigned_to->name ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->notes ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->remarks_by_telecaller ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->last_call_date ?? '' }}
                            </td>
                            <td>
                                {{ $leadsModule->service->title ?? '' }}
                            </td>
                            <td>
                                @can('leads_module_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.leads-modules.show', $leadsModule->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('leads_module_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.leads-modules.edit', $leadsModule->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('leads_module_delete')
                                    <form action="{{ route('admin.leads-modules.destroy', $leadsModule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('leads_module_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leads-modules.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-LeadsModule:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection