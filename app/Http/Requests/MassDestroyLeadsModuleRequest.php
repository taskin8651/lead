<?php

namespace App\Http\Requests;

use App\Models\LeadsModule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLeadsModuleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('leads_module_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:leads_modules,id',
        ];
    }
}
