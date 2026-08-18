<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-xl font-bold text-primary">{{ $donor->full_name }}</h2>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('donors.edit', $donor) }}" class="text-primary hover:underline">تعديل</a>
                <a href="{{ route('donors.index') }}" class="text-inkmuted hover:text-primary">رجوع للقائمة</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-surface border border-hairline rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
        <div>
            <p class="text-xs text-inkmuted mb-1">رقم الهوية الوطنية</p>
            <p class="text-sm">{{ $donor->national_id }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">رقم الجوال</p>
            <p class="text-sm">{{ $donor->phone }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">نوع الاستقطاع</p>
            <p class="text-sm">{{ $donor->deduction_type }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">المبلغ</p>
            <p class="text-sm">{{ number_format($donor->amount, 2) }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">الحالة</p>
            <p class="text-sm">{{ $donor->status === 'active' ? 'نشط' : 'موقوف' }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">أنشئ بواسطة</p>
            <p class="text-sm">{{ $donor->creator?->name ?? '—' }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-xs text-inkmuted mb-1">ملاحظات</p>
            <p class="text-sm">{{ $donor->notes ?: '—' }}</p>
        </div>
    </div>

    <h2 class="font-display text-lg font-bold text-primary mb-4">الاستقطاعات</h2>
    <div class="bg-surface border border-hairline rounded-xl overflow-hidden">
        <table class="w-full text-sm text-right">
            <thead class="bg-primarylight text-primarydark">
                <tr>
                    <th class="px-4 py-3">الشهر</th>
                    <th class="px-4 py-3">تاريخ الاستحقاق</th>
                    <th class="px-4 py-3">المبلغ</th>
                    <th class="px-4 py-3">الحالة</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @forelse ($donor->deductions as $deduction)
                    <tr>
                        <td class="px-4 py-3">{{ $deduction->month->format('Y-m') }}</td>
                        <td class="px-4 py-3">{{ $deduction->due_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ number_format($deduction->amount, 2) }}</td>
                        <td class="px-4 py-3">{{ $deduction->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-inkmuted">لا توجد استقطاعات.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
