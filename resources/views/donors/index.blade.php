<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-xl font-bold text-primary">المتبرعون</h2>
            <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'create-donor')"
                    class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-primarydark">إضافة متبرع</button>
        </div>
    </x-slot>

    <form method="GET" action="{{ route('donors.index') }}"
          class="flex flex-wrap gap-3 mb-6 bg-surface border border-hairline rounded-xl p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم..."
               class="flex-1 min-w-[200px] border border-hairline rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
        <select name="status" class="border border-hairline rounded-lg px-3 py-2 text-sm">
            <option value="">كل الحالات</option>
            <option value="active" @selected(request('status') === 'active')>نشط</option>
            <option value="suspended" @selected(request('status') === 'suspended')>موقوف</option>
        </select>
        <button type="submit"
                class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-primarydark">بحث</button>
        @if (request('search') || request('status'))
            <a href="{{ route('donors.index') }}" class="text-inkmuted text-sm px-4 py-2 hover:text-primary">إعادة تعيين</a>
        @endif
    </form>

    <div class="bg-surface border border-hairline rounded-xl overflow-hidden">
        <table class="w-full text-sm text-right">
            <thead class="bg-primarylight text-primarydark">
                <tr>
                    <th class="px-4 py-3">الاسم الكامل</th>
                    <th class="px-4 py-3">رقم الهوية</th>
                    <th class="px-4 py-3">الجوال</th>
                    <th class="px-4 py-3">نوع الاستقطاع</th>
                    <th class="px-4 py-3">المبلغ</th>
                    <th class="px-4 py-3">الحالة</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-hairline">
                @forelse ($donors as $donor)
                    <tr>
                        <td class="px-4 py-3">{{ $donor->full_name }}</td>
                        <td class="px-4 py-3">{{ $donor->national_id }}</td>
                        <td class="px-4 py-3">{{ $donor->phone }}</td>
                        <td class="px-4 py-3">{{ $donor->deduction_type }}</td>
                        <td class="px-4 py-3">{{ number_format($donor->amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block text-xs font-medium px-2 py-1 rounded-full {{ $donor->status === 'active' ? 'bg-primarylight text-primarydark' : 'bg-hairline text-inkmuted' }}">
                                {{ $donor->status === 'active' ? 'نشط' : 'موقوف' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('donors.show', $donor) }}" class="text-primary hover:underline">عرض</a>
                                <a href="{{ route('donors.edit', $donor) }}" class="text-primary hover:underline">تعديل</a>
                                @if (auth()->user()->role === 'admin')
                                    <form method="POST" action="{{ route('donors.destroy', $donor) }}"
                                          onsubmit="return confirm('هل أنت متأكد من إيقاف هذا المتبرع؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">إيقاف</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-inkmuted">لا يوجد متبرعون مطابقون.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $donors->links() }}
    </div>

    <x-modal name="create-donor" :show="$errors->isNotEmpty()">
        <form method="POST" action="{{ route('donors.store') }}" class="p-6">
            @csrf

            <h2 class="font-display text-lg font-bold text-primary mb-6">إضافة متبرع</h2>

            @include('donors._form')

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">إلغاء</x-secondary-button>
                <x-primary-button>حفظ</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
