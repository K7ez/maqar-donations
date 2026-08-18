<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تجربة Tailwind وRTL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-bg min-h-screen flex items-center justify-center">
    <div class="bg-surface border border-hairline rounded-2xl shadow-xl p-10 max-w-md text-center">
        <h1 class="font-display text-2xl font-bold text-primary mb-3">جمعية المقر للإسكان التنموي</h1>
        <p class="text-inkmuted text-sm mb-6">إذا شفت هذا التصميم بألوان وخطوط عربية واتجاه من اليمين لليسار، فهذا معناه Tailwind وRTL يشتغلون بنجاح.</p>
        <span class="inline-block bg-gold text-white text-xs font-medium px-4 py-2 rounded-lg">تم الإعداد بنجاح</span>
    </div>
</body>
</html>