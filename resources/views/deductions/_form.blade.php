<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-ink mb-1">المتبرع</label>
        <select name="donor_id" class="w-full border border-hairline rounded-lg px-3 py-2 text-sm">
            <option value="">اختر المتبرع</option>
            @foreach ($donors as $donorOption)
                <option value="{{ $donorOption->id }}" @selected((int) old('donor_id', $deduction->donor_id) === $donorOption->id)>
                    {{ $donorOption->full_name }}
                </option>
            @endforeach
        </select>
        @error('donor_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">الشهر</label>
        <input type="date" name="month" value="{{ old('month', optional($deduction->month)->format('Y-m-d')) }}"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('month') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">تاريخ الاستحقاق</label>
        <input type="date" name="due_date" value="{{ old('due_date', optional($deduction->due_date)->format('Y-m-d')) }}"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('due_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">المبلغ</label>
        <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount', $deduction->amount) }}"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('amount') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">الحالة</label>
        <select name="status" class="w-full border border-hairline rounded-lg px-3 py-2 text-sm">
            @foreach (['pending' => 'معلق', 'paid' => 'مدفوع', 'late' => 'متأخر'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $deduction->status ?: 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>
