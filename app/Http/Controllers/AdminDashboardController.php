<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\ProgramCluster;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with analytics.
     */
    public function index()
    {
        // Basic stats (same as previous closure)
        $totalRegistrations = Registration::count();
        $passedRegistrations = Registration::whereIn('status', ['approved', 'passed', 'lunas'])->count();
        $totalRevenue = \App\Models\Payment::whereIn('status', ['verified', 'paid'])->sum('amount');
        if ($totalRevenue == 0) {
            $totalRevenue = Registration::whereIn('status', ['paid', 'approved', 'passed'])->count() * 300000;
        }
        $boardingCount = Registration::where('is_boarding', true)->count();

        // Cluster distribution & quota percentage for doughnut chart
        $clusters = ProgramCluster::withCount('registrations')->get();
        $clusterLabels = $clusters->pluck('name')->toArray();
        $clusterCounts = $clusters->pluck('registrations_count')->toArray();
        $quotaPercentages = $clusters->map(function ($c) {
            return $c->quota > 0 ? round(($c->registrations_count / $c->quota) * 100, 1) : 0;
        })->toArray();

        // Status counts for bar chart
        $statusCounts = [
            Registration::where('status', 'draft')->count(),
            Registration::where('status', 'pending_payment')->count(),
            Registration::where('status', 'paid')->count(),
            Registration::where('status', 'revision_needed')->count(),
            Registration::whereIn('status', ['approved', 'passed'])->count(),
        ];

        // 1️⃣ Trend pendaftaran 7 hari terakhir (bar chart)
        $rawTrend = Registration::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        // Ensure array for each of the last 7 days
        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendLabels[] = $date;
            $found = $rawTrend->firstWhere('date', $date);
            $trendData[] = $found ? $found->count : 0;
        }

        return view('admin.dashboard', compact(
            'totalRegistrations',
            'passedRegistrations',
            'totalRevenue',
            'boardingCount',
            'clusterLabels',
            'clusterCounts',
            'statusCounts',
            'trendLabels',
            'trendData',
            'quotaPercentages'
        ));
    }
}

