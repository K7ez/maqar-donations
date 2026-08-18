<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'جمعية المقر للإسكان التنموي') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-body bg-bg min-h-screen text-ink antialiased">
        <div class="flex min-h-screen">
            @include('layouts.navigation')

            <div class="flex min-w-0 flex-1 flex-col lg:mr-64">
                <header class="bg-surface border-b border-hairline">
                    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-6 py-4">
                        <div class="flex min-w-0 items-center gap-4">
                            <button type="button" x-data x-on:click="$dispatch('toggle-sidebar')"
                                    class="text-inkmuted hover:text-primary lg:hidden">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                                </svg>
                            </button>

                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>

                        <button type="button" class="relative shrink-0 text-inkmuted hover:text-primary" aria-label="الإشعارات">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            <span class="absolute -top-0.5 -end-0.5 h-2 w-2 rounded-full bg-gold"></span>
                        </button>
                    </div>
                </header>

                <main class="mx-auto w-full max-w-6xl px-6 py-8">
                    @if (session('success'))
                        <div class="mb-6 rounded-lg border border-primarylight bg-primarylight px-4 py-3 text-sm text-primarydark">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
