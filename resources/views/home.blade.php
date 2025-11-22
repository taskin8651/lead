@extends('layouts.admin')

@section('content')
<style>
    /* Custom Dashboard Styles */
    .dashboard-card {
        border-radius: 12px;
        padding: 25px;
        color: #fff;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .dashboard-card i {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .status-card {
        border-radius: 10px;
        background-color: #fff;
        text-align: center;
        padding: 20px;
        border-left: 5px solid;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .status-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }

    .status-card i {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .filter-form .form-group {
        margin-right: 15px;
    }

    .filter-form button, .filter-form a {
        margin-top: 24px;
    }
</style>

<div class="content">

    {{-- Filter Form --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" class="form-inline filter-form bg-light p-3 rounded shadow-sm">
                <div class="form-group">
                    <label for="filter_type" class="mr-2">Quick Filter:</label>
                    <select name="filter_type" id="filter_type" class="form-control">
                        <option value="">-- Select --</option>
                        <option value="today" {{ request('filter_type')=='today'?'selected':'' }}>Today</option>
                        <option value="yesterday" {{ request('filter_type')=='yesterday'?'selected':'' }}>Yesterday</option>
                        <option value="7_days" {{ request('filter_type')=='7_days'?'selected':'' }}>Last 7 Days</option>
                        <option value="1_month" {{ request('filter_type')=='1_month'?'selected':'' }}>This Month</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="from_date" class="mr-2">From:</label>
                    <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="to_date" class="mr-2">To:</label>
                    <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.home') }}" class="btn btn-secondary ml-2">Reset</a>
            </form>
        </div>
    </div>

    {{-- Top Summary Cards --}}
    <div class="row mb-4">
        @if($totalUsers)
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card" style="background-color:#1E40AF;">
                <i class="fa fa-users"></i>
                <h5>Users</h5>
                <h3>{{ $totalUsers }}</h3>
            </div>
        </div>
        @endif

        @if($totalAdmins)
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card" style="background-color:#0D9488;">
                <i class="fa fa-user-shield"></i>
                <h5>Admins</h5>
                <h3>{{ $totalAdmins }}</h3>
            </div>
        </div>
        @endif

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card" style="background-color:#16A34A;">
                <i class="fa fa-address-book"></i>
                <h5>Total Leads</h5>
                <h3>{{ $totalLeads }}</h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card" style="background-color:#F59E0B;">
                <i class="fa fa-cogs"></i>
                <h5>Services</h5>
                <h3>{{ $totalServices }}</h3>
            </div>
        </div>
    </div>

  {{-- Status Cards --}}
<div class="row">
    @php
        $totalLeadsCount = array_sum($leadStatusCount->toArray());
        $statuses = [
            'total' => ['color' => '#6B7280', 'icon' => 'fa-chart-pie', 'label' => 'Total'], // Total card
            'new' => ['color' => '#1E40AF', 'icon' => 'fa-plus-circle', 'label' => 'New'],
            'in_progress' => ['color' => '#0D9488', 'icon' => 'fa-spinner', 'label' => 'In Progress'],
            'converted' => ['color' => '#16A34A', 'icon' => 'fa-check-circle', 'label' => 'Converted'],
            'callback' => ['color' => '#F59E0B', 'icon' => 'fa-phone', 'label' => 'Callback'],
            'not_interested' => ['color' => '#DC2626', 'icon' => 'fa-times-circle', 'label' => 'Not Interested'],
        ];
    @endphp

    @foreach($statuses as $key => $status)
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="status-card" style="border-left-color: {{ $status['color'] }};">
            <i class="fa {{ $status['icon'] }}" style="color: {{ $status['color'] }}"></i>
            <div class="mt-2">{{ $status['label'] }}</div>
            <div class="h4 mt-1">
                @if($key === 'total')
                    {{ $totalLeadsCount }}
                @else
                    {{ $leadStatusCount[$key] ?? 0 }}
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

</div>
@endsection
