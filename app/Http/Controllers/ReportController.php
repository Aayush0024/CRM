<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function __construct()
    {
        // Only admins and managers can access reports
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('access-reports')) {
                abort(403, __('messages.unauthorized'));
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();

        $totalRevenue = Deal::where('status', 'won')->sum('value');
        $totalDeals   = Deal::count();
        $wonDeals     = Deal::where('status', 'won')->count();
        $winRate      = $totalDeals > 0 ? round(($wonDeals / $totalDeals) * 100, 1) : 0;
        $avgDealValue = Deal::where('status', 'won')->avg('value') ?? 0;

        $totalLeads     = Lead::count();
        $convertedLeads = Lead::where('status', 'converted')->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 1) : 0;

        $monthlySales = Deal::where('status', 'won')
            ->selectRaw("strftime('%b %Y', actual_close_date) as month, SUM(value) as total")
            ->whereNotNull('actual_close_date')
            ->groupBy('month')
            ->orderBy('actual_close_date')
            ->limit(12)
            ->get();

        $topDeals = Deal::with('customer')->orderByDesc('value')->take(5)->get();

        $leadsBySource = Lead::selectRaw('source, count(*) as count')
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();

        $leadsByStatus = Lead::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        // Team performance — only for admins/managers
        $teamPerformance = null;
        if ($user->canViewReports()) {
            $teamPerformance = User::with('role')
                ->where('is_active', true)
                ->withCount(['leads', 'deals'])
                ->withSum(['deals as won_value' => fn ($q) => $q->where('status', 'won')], 'value')
                ->get();
        }

        return view('reports.index', compact(
            'totalRevenue', 'winRate', 'avgDealValue', 'conversionRate',
            'monthlySales', 'topDeals', 'leadsBySource', 'leadsByStatus',
            'totalLeads', 'teamPerformance'
        ));
    }

    public function sales()
    {
        return $this->index();
    }

    public function leads()
    {
        return $this->index();
    }
}
