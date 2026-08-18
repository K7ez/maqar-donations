<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-xl font-bold text-primary">الملف الشخصي</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-surface border border-hairline rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-surface border border-hairline rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-surface border border-hairline rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
