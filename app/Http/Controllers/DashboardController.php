<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->canViewAll()) {
            // Admins and managers see global stats
            $stats = [
                'total_customers'      => Customer::count(),
                'total_leads'          => Lead::count(),
                'open_deals'           => Deal::where('status', 'open')->count(),
                'total_deal_value'     => Deal::where('status', 'open')->sum('value'),
                'won_deals'            => Deal::where('status', 'won')->count(),
                'pending_tasks'        => Task::where('status', 'pending')->count(),
                'overdue_tasks'        => Task::where('status', 'pending')
                                              ->where('due_date', '<', now())->count(),
                'new_leads_this_month' => Lead::whereMonth('created_at', now()->month)->count(),
            ];
        } else {
            // Agents see only their own pipeline
            $stats = [
                'total_customers'      => Customer::where('assigned_to', $user->id)->count(),
                'total_leads'          => Lead::where('assigned_to', $user->id)->count(),
                'open_deals'           => Deal::where('status', 'open')
                                              ->where('assigned_to', $user->id)->count(),
                'total_deal_value'     => Deal::where('status', 'open')
                                              ->where('assigned_to', $user->id)->sum('value'),
                'won_deals'            => Deal::where('status', 'won')
                                              ->where('assigned_to', $user->id)->count(),
                'pending_tasks'        => Task::where('status', 'pending')
                                              ->where('assigned_to', $user->id)->count(),
                'overdue_tasks'        => Task::where('status', 'pending')
                                              ->where('due_date', '<', now())
                                              ->where('assigned_to', $user->id)->count(),
                'new_leads_this_month' => Lead::whereMonth('created_at', now()->month)
                                              ->where('assigned_to', $user->id)->count(),
            ];
        }

        $recentActivities = Activity::with('causer', 'subject')
            ->latest()
            ->take(10)
            ->get();

        $myTasks = Task::with('taskable')
            ->where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $recentCustomers = Customer::with('assignedTo')
            ->when(!$user->canViewAll(), fn ($q) => $q->where('assigned_to', $user->id))
            ->latest()
            ->take(5)
            ->get();

        $dealsByStage = Deal::where('status', 'open')
            ->when(!$user->canViewAll(), fn ($q) => $q->where('assigned_to', $user->id))
            ->selectRaw('stage, count(*) as count, sum(value) as total_value')
            ->groupBy('stage')
            ->get();

        $leadsByStatus = Lead::when(!$user->canViewAll(), fn ($q) => $q->where('assigned_to', $user->id))
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        return view('dashboard.index', compact(
            'stats', 'recentActivities', 'myTasks',
            'recentCustomers', 'dealsByStage', 'leadsByStatus'
        ));
    }
}
