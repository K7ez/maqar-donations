<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-xl font-bold text-primary">الاستقطاعات</h2>
            <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'create-deduction')"
                    class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-primarydark">تسجيل استقطاع جديد</button>
        </div>
    </x-slot>

    <form method="GET" action="{{ route('deductions.index') }}"
          class="flex flex-wrap gap-3 mb-6 bg-surface border border-hairline rounded-xl p-4">
        <input type="month" name="month" value="{{ request('month') }}"
               class="border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        <button type="submit"
                class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-primarydark">بحث</button>
        @if (request('month'))
            <a href="{{ route('deductions.index') }}" class="text-inkmuted text-sm px-4 py-2 hover:text-primary">إعادة تعيين</a>
        @endif
    </form>

    <div class="bg-surface border border-hairline rounded-xl overflow-hidden">
        <table class="w-full text-sm text-right">
            <thead class="bg-primarylight text-primarydark">
                <tr>
                    <th class="px-4 py-3">المتبرع</th>
                    <th class="px-4 py-3">الشهر</th>
                    <th class="px-4 py-3">تاريخ الاستحقاق</th>
                    <th class="px-4 py-3">المبلغ</th>
                    <th class="px-4 py-3">الحالة</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @forelse ($deductions as $deduction)
                    @php
                        $statusLabels = ['paid' => 'مدفوع', 'pending' => 'معلق', 'late' => 'متأخر'];
                        $statusClasses = [
                            'paid' => 'bg-primarylight text-primarydark',
                            'pending' => 'bg-hairline text-inkmuted',
                            'late' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <tr>
                        <td class="px-4 py-3">{{ $deduction->donor->full_name }}</td>
                        <td class="px-4 py-3">{{ $deduction->month->format('Y-m') }}</td>
                        <td class="px-4 py-3">{{ $deduction->due_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ number_format($deduction->amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block text-xs font-medium px-2 py-1 rounded-full {{ $statusClasses[$deduction->status] ?? 'bg-hairline text-inkmuted' }}">
                                {{ $statusLabels[$deduction->status] ?? $deduction->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('deductions.show', $deduction) }}" class="text-primary hover:underline">عرض</a>
                                <a href="{{ route('deductions.edit', $deduction) }}" class="text-primary hover:underline">تعديل</a>
                                @if ($deduction->status !== 'paid')
                                    <form method="POST" action="{{ route('deductions.confirm-payment', $deduction) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-primary hover:underline">تأكيد الدفع</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-inkmuted">لا توجد استقطاعات مطابقة.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $deductions->links() }}
    </div>

    <x-modal name="create-deduction" :show="$errors->isNotEmpty()">
        <form method="POST" action="{{ route('deductions.store') }}" class="p-6">
            @csrf

            <h2 class="font-display text-lg font-bold text-primary mb-6">تسجيل استقطاع جديد</h2>

            @include('deductions._form')

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">إلغاء</x-secondary-button>
                <x-primary-button>حفظ</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
