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

    @php
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services */
        $services = \App\Models\Service::query()
            ->whereNull('parent_id')
            ->where('active', true)
            ->orderBy('sort_order')
            ->get();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-4xl">
        @foreach($services as $service)
            <a href="{{ $service->url }}" class="{{ $service->card_class }}">
                <span class="text-4xl mb-3 block">
                    @if($service->icon)
                        {{ $service->icon }}
                    @else
                        <img src="{{ asset('images/service-fallback.png') }}" alt="" class="w-12 h-12 mx-auto object-contain block service-fallback-img" onerror="this.classList.add('!hidden'); this.nextElementSibling.classList.remove('hidden');">
                        <span class="service-fallback-emoji hidden">🎫</span>
                    @endif
                </span>
                <h2 class="text-xl font-bold text-slate-800">{{ $service->title }}</h2>
                <p class="text-slate-500 text-sm mt-0.5">{{ \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $service->key)) }}</p>
                <p class="text-slate-600 text-sm mt-1">{{ $service->subtitle ?: 'إصدار تذاكر ' . $service->title }}</p>
            </a>
        @endforeach
    </div>
</body>
</html>
