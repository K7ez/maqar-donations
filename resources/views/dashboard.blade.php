<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-xl font-bold text-primary">لوحة التحكم</h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-surface border border-hairline rounded-xl p-6">
            <p class="text-sm text-inkmuted">المتبرعون النشطون</p>
            <p class="mt-2 text-3xl font-semibold text-ink">{{ number_format($activeDonorsCount) }}</p>
        </div>

        <div class="bg-surface border border-hairline rounded-xl p-6">
            <p class="text-sm text-inkmuted">إجمالي استقطاعات هذا الشهر</p>
            <p class="mt-2 text-3xl font-semibold text-ink">{{ number_format($currentMonthTotal, 2) }}</p>
        </div>

        <div class="bg-surface border border-hairline rounded-xl p-6">
            <p class="text-sm text-inkmuted">عدد الأسر المستفيدة</p>
            <p class="mt-2 text-3xl font-semibold text-ink">{{ number_format($beneficiaryFamiliesCount) }}</p>
        </div>

        <div class="bg-surface border border-hairline rounded-xl p-6">
            <p class="text-sm text-inkmuted">نسبة التحصيل</p>
            <p class="mt-2 text-3xl font-semibold text-ink">{{ number_format($collectionRate, 1) }}%</p>
            <div class="mt-3 h-2 w-full rounded-full bg-primarylight overflow-hidden">
                <div class="h-full rounded-full bg-primary" style="width: {{ min(100, max(0, $collectionRate)) }}%"></div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-surface border border-hairline rounded-xl p-6">
            <h3 class="font-display text-base font-bold text-primary mb-6">نسبة التحصيل خلال آخر 6 أشهر</h3>

            <div class="flex items-end justify-between gap-3">
                @foreach ($monthlyCollectionRates as $month)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <span class="text-xs font-semibold text-ink">{{ $month['rate'] }}%</span>
                        <div class="flex h-32 w-full items-end overflow-hidden rounded-md bg-primarylight">
                            <div class="w-full rounded-t-md bg-primary" style="height: {{ max(4, $month['rate']) }}%"></div>
                        </div>
                        <span class="text-xs text-inkmuted">{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-surface border border-hairline rounded-xl p-6">
            <h3 class="font-display text-base font-bold text-primary mb-4">أحدث الاستقطاعات</h3>

            @php
                $statusLabels = ['paid' => 'مدفوع', 'pending' => 'معلق', 'late' => 'متأخر'];
                $statusClasses = [
                    'paid' => 'bg-primarylight text-primarydark',
                    'pending' => 'bg-hairline text-inkmuted',
                    'late' => 'bg-red-100 text-red-700',
                ];
            @endphp

            <ul class="divide-y divide-hairline">
                @forelse ($recentDeductions as $deduction)
                    <li class="flex items-center justify-between py-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-ink truncate">{{ $deduction->donor->full_name }}</p>
                            <p class="text-xs text-inkmuted">{{ $deduction->month->format('Y-m') }}</p>
                        </div>
                        <span class="inline-block text-xs font-medium px-2 py-1 rounded-full shrink-0 {{ $statusClasses[$deduction->status] ?? 'bg-hairline text-inkmuted' }}">
                            {{ $statusLabels[$deduction->status] ?? $deduction->status }}
                        </span>
                    </li>
                @empty
                    <li class="py-6 text-center text-sm text-inkmuted">لا توجد استقطاعات بعد.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
