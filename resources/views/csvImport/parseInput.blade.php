@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">Map CSV Fields</div>

    <div class="card-body">
        <form method="POST" action="{{ route($routeName) }}">
            {{ csrf_field() }}

            {{-- HIDDEN FIELDS --}}
            <input type="hidden" name="filename" value="{{ $filename }}">
            <input type="hidden" name="hasHeader" value="{{ $hasHeader }}">
            <input type="hidden" name="modelName" value="{{ $modelName }}">
            <input type="hidden" name="redirect" value="{{ $redirect }}">
            <input type="hidden" name="assigned_to_id" value="{{ $assigned_to_id }}">
            <input type="hidden" name="service_id" value="{{ $service_id }}">
            <input type="hidden" name="status" value="{{ $status }}">  {{-- ⭐ FIXED --}}

            <table class="table table-bordered">

                {{-- SHOW HEADERS --}}
                <tr>
                    @foreach($headers as $field)
                        <th>{{ $field }}</th>
                    @endforeach
                </tr>

                {{-- SHOW SAMPLE ROWS --}}
                @foreach($lines as $line)
                    <tr>
                        @foreach($line as $field)
                            <td>{{ $field }}</td>
                        @endforeach
                    </tr>
                @endforeach

                {{-- FIELD MAPPING --}}
                <tr>
                    @foreach($headers as $key => $header)
                        <td>
                            <select name="fields[{{ $key }}]" class="form-control">
                                <option value="">Select</option>

                                @foreach($fillables as $fillable)
                                    <option value="{{ $fillable }}"
                                        {{ strtolower($header) == strtolower($fillable) ? 'selected' : '' }}>
                                        {{ $fillable }}
                                    </option>
                                @endforeach

                            </select>
                        </td>
                    @endforeach
                </tr>

            </table>

            <button class="btn btn-success">Import</button>

        </form>
    </div>
</div>

@endsection
