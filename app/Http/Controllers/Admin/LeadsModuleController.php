<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyLeadsModuleRequest;
use App\Http\Requests\StoreLeadsModuleRequest;
use App\Http\Requests\UpdateLeadsModuleRequest;
use App\Models\LeadsModule;
use App\Models\Service;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeadsModuleController extends Controller
{
    use CsvImportTrait;

   public function index(Request $request)
{
    abort_if(Gate::denies('leads_module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $query = LeadsModule::query()->with(['assigned_to', 'service']);

    // 🔹 If not admin → show only assigned leads
    if (!auth()->user()->is_admin) {
        $query->where('assigned_to_id', auth()->id());
    }

    // 🔹 Quick Filter
    if ($request->filter_type) {
        if ($request->filter_type == 'today') {
            $query->whereDate('created_at', today());
        } elseif ($request->filter_type == 'yesterday') {
            $query->whereDate('created_at', today()->subDay());
        } elseif ($request->filter_type == '7_days') {
            $query->whereDate('created_at', '>=', now()->subDays(7));
        } elseif ($request->filter_type == '15_days') {
            $query->whereDate('created_at', '>=', now()->subDays(15));
        } elseif ($request->filter_type == '1_month') {
            $query->whereDate('created_at', '>=', now()->subMonth());
        }
    }

    // 🔹 Custom Date Range
    if ($request->from_date && $request->to_date) {
        $query->whereBetween('created_at', [
            $request->from_date . ' 00:00:00',
            $request->to_date . ' 23:59:59'
        ]);
    }

    // 🔹 Status Filter
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $leadsModules = $query->latest()->get();

    return view('admin.leadsModules.index', compact('leadsModules'));
}



    public function create()
    {
        abort_if(Gate::denies('leads_module_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assigned_tos = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.leadsModules.create', compact('assigned_tos', 'services'));
    }

    public function store(StoreLeadsModuleRequest $request)
    {
        $leadsModule = LeadsModule::create($request->all());

        return redirect()->route('admin.leads-modules.index');
    }

    public function edit(LeadsModule $leadsModule)
    {
        abort_if(Gate::denies('leads_module_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assigned_tos = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leadsModule->load('assigned_to', 'service');

        return view('admin.leadsModules.edit', compact('assigned_tos', 'leadsModule', 'services'));
    }

    public function update(UpdateLeadsModuleRequest $request, LeadsModule $leadsModule)
    {
        $leadsModule->update($request->all());

        return redirect()->route('admin.leads-modules.index');
    }

    public function show(LeadsModule $leadsModule)
    {
        abort_if(Gate::denies('leads_module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leadsModule->load('assigned_to', 'service');

        return view('admin.leadsModules.show', compact('leadsModule'));
    }

    public function destroy(LeadsModule $leadsModule)
    {
        abort_if(Gate::denies('leads_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leadsModule->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeadsModuleRequest $request)
    {
        $leadsModules = LeadsModule::find(request('ids'));

        foreach ($leadsModules as $leadsModule) {
            $leadsModule->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
