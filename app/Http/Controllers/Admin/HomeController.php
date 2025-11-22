<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Service;
use App\Models\LeadsModule;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Base query for leads based on role
        if ($user->roles()->where('id', 3)->exists()) { // SUPER ADMIN
            $leadsQuery = LeadsModule::query();
        } elseif ($user->roles()->where('id', 1)->exists()) { // ADMIN
            $leadsQuery = LeadsModule::where('created_by_id', $user->id);
        } else { // NORMAL USER
            $leadsQuery = LeadsModule::where('assigned_to_id', $user->id);
        }

        // --------- Quick Filter by Date ---------
        if ($request->filter_type) {
            switch ($request->filter_type) {
                case 'today':
                    $leadsQuery->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $leadsQuery->whereDate('created_at', today()->subDay());
                    break;
                case '7_days':
                    $leadsQuery->whereDate('created_at', '>=', now()->subDays(7));
                    break;
                case '1_month':
                    $leadsQuery->whereDate('created_at', '>=', now()->subMonth());
                    break;
            }
        }

        // --------- Custom Date Range ---------
        if ($request->from_date && $request->to_date) {
            $leadsQuery->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // --------- Counts ---------
        $totalUsers = $user->roles()->where('id', 3)->exists() 
            ? User::count() 
            : ($user->roles()->where('id', 1)->exists() ? User::where('created_by_id', $user->id)->count() : 0);

        $totalAdmins = $user->roles()->where('id', 3)->exists() 
            ? User::whereHas('roles', fn($q) => $q->where('id', 1))->count() 
            : 0;

        $totalLeads = $leadsQuery->count();
        $totalServices = Service::count();

        // --------- Status wise count ---------
        $leadStatusCount = (clone $leadsQuery)
            ->select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total','status');

        return view('home', compact(
            'totalUsers',
            'totalAdmins',
            'totalLeads',
            'totalServices',
            'leadStatusCount'
        ));
    }
}
