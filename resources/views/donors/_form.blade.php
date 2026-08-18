<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-ink mb-1">الاسم الكامل</label>
        <input type="text" name="full_name" value="{{ old('full_name', $donor->full_name) }}"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('full_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">رقم الهوية الوطنية</label>
        <input type="text" name="national_id" value="{{ old('national_id', $donor->national_id) }}"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('national_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">رقم الجوال</label>
        <input type="text" name="phone" value="{{ old('phone', $donor->phone) }}" placeholder="05xxxxxxxx"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('phone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">نوع الاستقطاع</label>
        <select name="deduction_type" class="w-full border border-hairline rounded-lg px-3 py-2 text-sm">
            <option value="">اختر النوع</option>
            @foreach (['monthly' => 'شهري', 'yearly' => 'سنوي', 'one_time' => 'لمرة واحدة'] as $value => $label)
                <option value="{{ $value }}" @selected(old('deduction_type', $donor->deduction_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('deduction_type') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">المبلغ</label>
        <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount', $donor->amount) }}"
               class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        @error('amount') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-ink mb-1">الحالة</label>
        <select name="status" class="w-full border border-hairline rounded-lg px-3 py-2 text-sm">
            @foreach (['active' => 'نشط', 'suspended' => 'موقوف'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $donor->status ?: 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-ink mb-1">ملاحظات</label>
        <textarea name="notes" rows="3"
                  class="w-full border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">{{ old('notes', $donor->notes) }}</textarea>
        @error('notes') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>
