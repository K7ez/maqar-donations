<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Models\Donor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $donors = Donor::query()
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where('full_name', 'like', '%'.$request->query('search').'%')
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', $request->query('status'))
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('donors.index', [
            'donors' => $donors,
            'donor' => new Donor(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('donors.create', ['donor' => new Donor()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonorRequest $request): RedirectResponse
    {
        Donor::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('donors.index')
            ->with('success', 'تمت إضافة المتبرع بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donor $donor): View
    {
        $donor->load('deductions', 'creator');

        return view('donors.show', compact('donor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donor $donor): View
    {
        return view('donors.edit', compact('donor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonorRequest $request, Donor $donor): RedirectResponse
    {
        $donor->update($request->validated());

        return redirect()
            ->route('donors.index')
            ->with('success', 'تم تحديث بيانات المتبرع بنجاح.');
    }

    /**
     * Suspend the specified resource instead of deleting it.
     */
    public function destroy(Donor $donor): RedirectResponse
    {
        $donor->update(['status' => 'suspended']);

        return redirect()
            ->route('donors.index')
            ->with('success', 'تم إيقاف المتبرع بنجاح.');
    }
}
