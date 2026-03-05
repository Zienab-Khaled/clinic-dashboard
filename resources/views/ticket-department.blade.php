<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تذكرة - {{ $departmentName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body * { visibility: hidden; }
            .ticket-container, .ticket-container * { visibility: visible; }
            .ticket-container {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 1.5rem !important;
                box-shadow: none !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
        }
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="no-print p-4 text-center">
        <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded">طباعة التذكرة</button>
        <a href="{{ $backUrl }}" class="ml-3 px-4 py-2 bg-blue-600 text-white rounded inline-block">العودة</a>
    </div>
    <div class="ticket-container max-w-xl mx-auto my-12 p-8 rounded-lg shadow-lg overflow-hidden relative"
         style="background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}'); background-size: cover; background-position: center;">
        <div class="relative z-10">
            <div class="flex justify-end mb-2">
                <img src="{{ asset('images/logo.jpg') }}" alt="شعار المستشفى" class="w-16 h-16 object-contain" onerror="this.style.display='none'">
            </div>
            <h2 class="text-4xl font-bold text-center my-6">{{ $departmentName }}</h2>
            <p class="text-8xl font-bold text-center my-6">{{ $ticketNumber }}</p>
            <div class="flex flex-col items-center my-6">
                <p class="text-sm text-slate-600 mb-2">امسح الباركود لمتابعة رقمك والانتظار</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($trackUrl ?? '') }}" alt="باركود المتابعة" class="w-28 h-28 rounded border border-slate-200">
            </div>
            <div class="text-right text-xl space-y-1 mt-8">
                <p>{{ $date }}</p>
                <p>{{ $time }}</p>
                <p class="font-bold text-lg mt-2">{{ $hospitalName }}</p>
            </div>
        </div>
    </div>
    <script>
        if (window.opener && {{ $departmentId ?? 0 }}) {
            window.opener.postMessage({ type: 'ticket-issued-dept', departmentId: {{ $departmentId }} }, '*');
        }
    </script>
</body>
</html>
