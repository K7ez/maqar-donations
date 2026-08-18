@php
    $roleLabels = ['admin' => 'مدير', 'staff' => 'موظف'];
@endphp

<div x-data="{ open: false }" x-on:toggle-sidebar.window="open = ! open">
    <div
        x-show="open"
        x-on:click="open = false"
        x-transition.opacity
        class="fixed inset-0 z-30 bg-black/40 lg:hidden"
        style="display: none;"
    ></div>

    <aside
        :class="open ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 right-0 z-40 flex w-64 shrink-0 flex-col bg-primarydark transition-transform duration-200 ease-in-out lg:translate-x-0"
    >
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 border-b border-white/10 px-5 py-6">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gold font-display text-lg font-bold text-primarydark">
                م
            </span>
            <span class="min-w-0">
                <span class="block truncate font-display text-sm font-bold text-white">جمعية المقر</span>
                <span class="block text-xs text-primarylight/70">القنفذة</span>
            </span>
        </a>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            <a href="{{ route('dashboard') }}"
               @class([
                   'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition',
                   'bg-primary text-white' => request()->routeIs('dashboard'),
                   'text-primarylight/80 hover:bg-white/5 hover:text-white' => ! request()->routeIs('dashboard'),
               ])>
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                لوحة التحكم
            </a>

            <a href="{{ route('donors.index') }}"
               @class([
                   'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition',
                   'bg-primary text-white' => request()->routeIs('donors.*'),
                   'text-primarylight/80 hover:bg-white/5 hover:text-white' => ! request()->routeIs('donors.*'),
               ])>
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                إدارة المتبرعين
            </a>

            <a href="{{ route('deductions.index') }}"
               @class([
                   'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition',
                   'bg-primary text-white' => request()->routeIs('deductions.*'),
                   'text-primarylight/80 hover:bg-white/5 hover:text-white' => ! request()->routeIs('deductions.*'),
               ])>
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                الاستقطاعات الشهرية
            </a>
        </nav>

        <div class="border-t border-white/10 p-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-lg px-1 py-1.5 hover:bg-white/5">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-semibold text-white">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-medium text-white">{{ Auth::user()->name }}</span>
                    <span class="block text-xs text-primarylight/70">{{ $roleLabels[Auth::user()->role] ?? Auth::user()->role }}</span>
                </span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-1 py-1.5 text-xs font-medium text-primarylight/80 transition hover:text-gold">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>
</div>
