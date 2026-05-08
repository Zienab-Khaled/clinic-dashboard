<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تذكرة - {{ $departmentName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }

            html, body {
                width: 58mm;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            body * { visibility: hidden; }
            .ticket-container, .ticket-container * { visibility: visible; }
            .ticket-container {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 58mm !important;
                max-width: 58mm !important;
                margin: 0 !important;
                padding: 2mm !important;
                box-shadow: none !important;
                background: white !important;
                border-radius: 0 !important;
            }
            .ticket-container h2 {
                font-size: 15px !important;
                line-height: 1.2 !important;
                margin: 2mm 0 !important;
            }
            .ticket-container p {
                margin: 1mm 0 !important;
            }
            .ticket-container .text-6xl {
                font-size: 32px !important;
                line-height: 1 !important;
            }
            .ticket-container .text-lg {
                font-size: 12px !important;
            }
            .ticket-container .text-base {
                font-size: 12px !important;
            }
            .ticket-container .text-xs {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }
            .ticket-container img.w-12 {
                width: 30px !important;
                height: 30px !important;
            }
            .ticket-container img.w-24 {
                width: 64px !important;
                height: 64px !important;
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
    <div class="ticket-container max-w-sm mx-auto my-6 p-4 rounded-lg shadow-lg overflow-hidden relative"
         style="background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}'); background-size: cover; background-position: center;">
        <div class="relative z-10">
            <div class="flex justify-end mb-1">
                <img src="{{ asset('images/logo.jpg') }}" alt="شعار المستشفى" class="w-12 h-12 object-contain" onerror="this.style.display='none'">
            </div>
            <h2 class="text-2xl font-bold text-center my-2">{{ $department->name }}</h2>
            @if(!empty($department->name_en))
                <p class="text-lg text-slate-600 text-center -mt-1 mb-1">{{ $department->name_en }}</p>
            @endif
            <p class="text-6xl font-bold text-center my-2">{{ $ticketNumber }}</p>
            <div class="flex flex-col items-center my-2">
                <p class="text-xs text-slate-600 mb-1">امسح الباركود لمتابعة رقمك والانتظار</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($trackUrl ?? '') }}" alt="باركود المتابعة" class="w-24 h-24 rounded border border-slate-200">
            </div>
            <div class="text-right text-base space-y-0.5 mt-4">
                <p>{{ $date }}</p>
                <p>{{ $time }}</p>
                <p class="font-bold text-sm mt-1">{{ $hospitalName }}</p>
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
