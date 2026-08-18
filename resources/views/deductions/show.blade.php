<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-xl font-bold text-primary">استقطاع {{ $deduction->donor->full_name }}</h2>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('deductions.edit', $deduction) }}" class="text-primary hover:underline">تعديل</a>
                <a href="{{ route('deductions.index') }}" class="text-inkmuted hover:text-primary">رجوع للقائمة</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-surface border border-hairline rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <p class="text-xs text-inkmuted mb-1">المتبرع</p>
            <p class="text-sm">{{ $deduction->donor->full_name }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">الشهر</p>
            <p class="text-sm">{{ $deduction->month->format('Y-m') }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">تاريخ الاستحقاق</p>
            <p class="text-sm">{{ $deduction->due_date->format('Y-m-d') }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">المبلغ</p>
            <p class="text-sm">{{ number_format($deduction->amount, 2) }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">الحالة</p>
            <p class="text-sm">{{ $deduction->status }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">تاريخ الدفع</p>
            <p class="text-sm">{{ $deduction->paid_at?->format('Y-m-d H:i') ?? '—' }}</p>
        </div>
        <div>
            <p class="text-xs text-inkmuted mb-1">تم التأكيد بواسطة</p>
            <p class="text-sm">{{ $deduction->confirmer?->name ?? '—' }}</p>
        </div>
    </div>

    @if ($deduction->status !== 'paid')
        <form method="POST" action="{{ route('deductions.confirm-payment', $deduction) }}" class="mt-6">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="bg-primary text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-primarydark">تأكيد الدفع</button>
        </form>
    @endif
</x-app-layout>
