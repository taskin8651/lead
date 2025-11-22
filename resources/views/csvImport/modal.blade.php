<div class="modal fade" id="csvImportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">@lang('global.app_csvImport')</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST"
                      action="{{ route($route, ['model' => $model]) }}"
                      enctype="multipart/form-data">

                    {{ csrf_field() }}

                 @php
    $currentUser = auth()->user();

    // SUPER ADMIN (role id = 1)
    $isSuperAdmin = $currentUser->roles()->where('id', 3)->exists();

    if ($isSuperAdmin) {
        // Super admin → all users
        $users = \App\Models\User::all();
    } else {
        // Admin → only users created by this admin
        $users = \App\Models\User::where('created_by_id', $currentUser->id)->get();
    }
@endphp

<select name="assigned_to_id" class="form-control" required>
    <option value="">Select Telecaller</option>
    @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</select>


                    {{-- Service --}}
                    <div class="form-group">
                        <label>Service</label>
                        <select name="service_id" class="form-control" required>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="new" selected>New</option>
                            @foreach(\App\Models\LeadsModule::STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CSV --}}
                    <div class="form-group">
                        <label>@lang('global.app_csv_file_to_import')</label>
                        <input type="file" name="csv_file" class="form-control" required>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="header" checked>
                            Header Row Included
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        @lang('global.app_parse_csv')
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>
