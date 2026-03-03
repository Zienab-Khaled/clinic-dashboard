<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تذكرة - {{ $clinicName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: A5;
                margin: 12mm;
            }
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            body * { visibility: hidden; }
            .ticket-container, .ticket-container * { visibility: visible; }
            .ticket-container {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 1rem 1.5rem !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                background: white !important;
                background-image: none !important;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-200">
    <div class="no-print p-4 text-center">
        <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded">طباعة التذكرة</button>
        <a href="{{ url('/admin') }}" class="ml-3 px-4 py-2 bg-blue-600 text-white rounded inline-block">العودة للوحة التحكم</a>
    </div>
    <div class="ticket-container max-w-xl mx-auto my-12 p-8 rounded-lg shadow-lg overflow-hidden relative"
         style="background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset('images/background.jpg') }}'); background-size: cover; background-position: center;">
        <div class="relative z-10">
            {{-- اللوجو في الأعلى --}}
            <div class="flex justify-end mb-2">
                <img src="{{ asset('images/logo.jpg') }}" alt="شعار المستشفى" class="w-16 h-16 object-contain" onerror="this.style.display='none'">
            </div>
            {{-- اسم العيادة في النص --}}
            <h2 class="text-4xl font-bold text-center my-6">عيادة {{ $clinicName }}</h2>
            {{-- رقم التذكرة كبير في النص --}}
            <p class="text-8xl font-bold text-center my-6">{{ $ticketNumber }}</p>
            {{-- الداتا المكتوبة زي القديم: تاريخ، وقت، اسم المستشفى محاذاة لليمين --}}
            <div class="text-right text-xl space-y-1 mt-8">
                <p>{{ $date }}</p>
                <p>{{ $time }}</p>
                <p class="font-bold text-lg mt-2">{{ $hospitalName }}</p>
            </div>
        </div>
    </div>
</body>
</html>
