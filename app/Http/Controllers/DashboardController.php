<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryFamily;
use App\Models\Deduction;
use App\Models\Donor;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with summary statistics.
     */
    public function index(): View
    {
        $activeDonorsCount = Donor::where('status', 'active')->count();

        $currentMonthDeductions = Deduction::whereYear('month', now()->year)
            ->whereMonth('month', now()->month);

        $currentMonthTotal = (clone $currentMonthDeductions)->sum('amount');
        $currentMonthPaid = (clone $currentMonthDeductions)->where('status', 'paid')->sum('amount');

        $collectionRate = $currentMonthTotal > 0
            ? round(($currentMonthPaid / $currentMonthTotal) * 100, 1)
            : 0;

        $beneficiaryFamiliesCount = BeneficiaryFamily::count();

        $monthNames = ['', 'ينا', 'فبر', 'مار', 'أبر', 'ماي', 'يون', 'يول', 'أغس', 'سبت', 'أكت', 'نوف', 'ديس'];

        $monthlyCollectionRates = collect(range(5, 0))->map(function ($monthsAgo) use ($monthNames) {
            $month = now()->subMonths($monthsAgo)->startOfMonth();

            $monthDeductions = Deduction::whereYear('month', $month->year)
                ->whereMonth('month', $month->month);

            $total = (clone $monthDeductions)->sum('amount');
            $paid = (clone $monthDeductions)->where('status', 'paid')->sum('amount');

            return [
                'label' => $monthNames[$month->month],
                'rate' => $total > 0 ? round(($paid / $total) * 100, 1) : 0,
            ];
        });

        $recentDeductions = Deduction::with('donor')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'activeDonorsCount' => $activeDonorsCount,
            'currentMonthTotal' => $currentMonthTotal,
            'beneficiaryFamiliesCount' => $beneficiaryFamiliesCount,
            'collectionRate' => $collectionRate,
            'monthlyCollectionRates' => $monthlyCollectionRates,
            'recentDeductions' => $recentDeductions,
        ]);
    }
}
