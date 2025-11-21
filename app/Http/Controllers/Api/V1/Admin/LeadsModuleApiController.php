<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadsModuleRequest;
use App\Http\Requests\UpdateLeadsModuleRequest;
use App\Http\Resources\Admin\LeadsModuleResource;
use App\Models\LeadsModule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeadsModuleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leads_module_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeadsModuleResource(LeadsModule::with(['assigned_to', 'service'])->get());
    }

    public function store(StoreLeadsModuleRequest $request)
    {
        $leadsModule = LeadsModule::create($request->all());

        return (new LeadsModuleResource($leadsModule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LeadsModule $leadsModule)
    {
        abort_if(Gate::denies('leads_module_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeadsModuleResource($leadsModule->load(['assigned_to', 'service']));
    }

    public function update(UpdateLeadsModuleRequest $request, LeadsModule $leadsModule)
    {
        $leadsModule->update($request->all());

        return (new LeadsModuleResource($leadsModule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LeadsModule $leadsModule)
    {
        abort_if(Gate::denies('leads_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leadsModule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
