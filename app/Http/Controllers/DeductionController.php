<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeductionRequest;
use App\Models\Deduction;
use App\Models\Donor;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $deductions = Deduction::query()
            ->with('donor')
            ->when($request->filled('month'), function ($query) use ($request) {
                $month = Carbon::parse($request->query('month'));

                $query->whereYear('month', $month->year)
                    ->whereMonth('month', $month->month);
            })
            ->latest('due_date')
            ->paginate(15)
            ->withQueryString();

        return view('deductions.index', [
            'deductions' => $deductions,
            'deduction' => new Deduction(),
            'donors' => Donor::orderBy('full_name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('deductions.create', [
            'deduction' => new Deduction(),
            'donors' => Donor::orderBy('full_name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeductionRequest $request): RedirectResponse
    {
        Deduction::create($request->validated());

        return redirect()
            ->route('deductions.index')
            ->with('success', 'تمت إضافة الاستقطاع بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deduction $deduction): View
    {
        $deduction->load('donor', 'confirmer');

        return view('deductions.show', compact('deduction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deduction $deduction): View
    {
        return view('deductions.edit', [
            'deduction' => $deduction,
            'donors' => Donor::orderBy('full_name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDeductionRequest $request, Deduction $deduction): RedirectResponse
    {
        $deduction->update($request->validated());

        return redirect()
            ->route('deductions.index')
            ->with('success', 'تم تحديث الاستقطاع بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deduction $deduction): RedirectResponse
    {
        $deduction->delete();

        return redirect()
            ->route('deductions.index')
            ->with('success', 'تم حذف الاستقطاع بنجاح.');
    }

    /**
     * Mark the specified deduction as paid.
     */
    public function confirmPayment($id): RedirectResponse
    {
        $deduction = Deduction::findOrFail($id);

        $deduction->update([
            'status' => 'paid',
            'paid_at' => now(),
            'confirmed_by' => auth()->id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'تم تأكيد الدفع بنجاح.');
    }
}
