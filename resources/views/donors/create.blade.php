<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-xl font-bold text-primary">إضافة متبرع</h2>
    </x-slot>

    <form method="POST" action="{{ route('donors.store') }}" class="bg-surface border border-hairline rounded-xl p-6">
        @csrf
        @include('donors._form')

        <div class="mt-6 flex items-center gap-3">
            <button type="submit"
                    class="bg-primary text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-primarydark">حفظ</button>
            <a href="{{ route('donors.index') }}" class="text-inkmuted text-sm hover:text-primary">إلغاء</a>
        </div>
    </form>
</x-app-layout>
