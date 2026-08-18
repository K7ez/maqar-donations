<x-guest-layout>
    <div class="mb-4 text-sm text-inkmuted">
        شكرًا لتسجيلك! هل يمكنك تأكيد بريدك الإلكتروني بالنقر على الرابط الذي أرسلناه إليك للتو؟ إذا لم تصلك الرسالة، سنكون سعداء بإرسال رسالة أخرى.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-primary">
            تم إرسال رابط تأكيد جديد إلى البريد الإلكتروني الذي أدخلته عند التسجيل.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    إعادة إرسال رابط التأكيد
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-inkmuted hover:text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                تسجيل الخروج
            </button>
        </form>
    </div>
</x-guest-layout>
