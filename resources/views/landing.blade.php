<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ setting('hospital_name', 'مستشفى الملك عبد العزيز التخصصي بالجوف') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .card-main { transition: transform 0.2s, box-shadow 0.2s; }
        .card-main:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgb(0 0 0 / 0.15); }
    </style>
</head>
<body class="min-h-screen p-4 md:p-8 flex flex-col items-center justify-center">
    <div class="max-w-4xl w-full text-center mb-10">
        <img src="{{ asset('images/logo.jpg') }}" alt="شعار المستشفى" class="w-20 h-20 md:w-24 md:h-24 object-contain mx-auto rounded-lg mb-4" onerror="this.style.display='none'">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">{{ setting('hospital_name', 'مستشفى الملك عبد العزيز التخصصي بالجوف') }}</h1>
        <p class="text-slate-600 mt-2">اختر الخدمة</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full max-w-3xl">
        <a href="{{ url('/staff') }}" class="card-main rounded-2xl border-2 border-amber-400 bg-amber-50 hover:bg-amber-100 p-8 shadow-lg text-center block">
            <span class="text-4xl mb-3 block">🏥</span>
            <h2 class="text-xl font-bold text-slate-800">العيادات</h2>
            <p class="text-slate-600 text-sm mt-1">إصدار تذاكر العيادات</p>
        </a>
        <a href="{{ url('/department/radiology') }}" class="card-main rounded-2xl border-2 border-sky-400 bg-sky-50 hover:bg-sky-100 p-8 shadow-lg text-center block">
            <span class="text-4xl mb-3 block">📷</span>
            <h2 class="text-xl font-bold text-slate-800">الأشعة</h2>
            <p class="text-slate-600 text-sm mt-1">إصدار تذاكر الأشعة</p>
        </a>
        <a href="{{ url('/department/pharmacy') }}" class="card-main rounded-2xl border-2 border-emerald-400 bg-emerald-50 hover:bg-emerald-100 p-8 shadow-lg text-center block">
            <span class="text-4xl mb-3 block">💊</span>
            <h2 class="text-xl font-bold text-slate-800">الصيدلية</h2>
            <p class="text-slate-600 text-sm mt-1">إصدار تذاكر الصيدلية</p>
        </a>
        <a href="{{ url('/department/lab') }}" class="card-main rounded-2xl border-2 border-violet-400 bg-violet-50 hover:bg-violet-100 p-8 shadow-lg text-center block">
            <span class="text-4xl mb-3 block">🔬</span>
            <h2 class="text-xl font-bold text-slate-800">المختبر</h2>
            <p class="text-slate-600 text-sm mt-1">إصدار تذاكر المختبر</p>
        </a>
    </div>
</body>
</html>
