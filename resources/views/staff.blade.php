<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شاشة الموظف - إصدار التذاكر</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset("images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .card-clinic { transition: transform 0.2s, box-shadow 0.2s; }
        .card-clinic:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1); }
    </style>
</head>
<body class="min-h-screen p-4 md:p-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 mb-8">
            <img src="{{ asset('images/logo.jpg') }}" alt="شعار المستشفى" class="w-16 h-16 md:w-20 md:h-20 object-contain rounded-lg" onerror="this.style.display='none'">
            <div class="text-center md:text-right">
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">شاشة الموظف - العيادات</h1>
                <p class="text-slate-600 mt-1">اختر العيادة لإصدار تذكرة بالرقم الجديد</p>
            </div>
            <a href="{{ route('home') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg">الرئيسية</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @php
                $colors = [
                    'amber' => 'border-amber-400 bg-amber-50 hover:bg-amber-100',
                    'emerald' => 'border-emerald-400 bg-emerald-50 hover:bg-emerald-100',
                    'sky' => 'border-sky-400 bg-sky-50 hover:bg-sky-100',
                    'violet' => 'border-violet-400 bg-violet-50 hover:bg-violet-100',
                    'rose' => 'border-rose-400 bg-rose-50 hover:bg-rose-100',
                    'teal' => 'border-teal-400 bg-teal-50 hover:bg-teal-100',
                ];
                $colorKeys = array_keys($colors);
            @endphp
            @foreach($clinics as $index => $clinic)
                @php
                    $colorClass = $colors[$colorKeys[$index % count($colors)]];
                    $waiting = $clinic->patient_number - $clinic->current_serving;
                @endphp
                <div class="card-clinic rounded-xl border-2 {{ $colorClass }} p-5 shadow-md bg-white/95" data-clinic-id="{{ $clinic->id }}">
                    <p class="text-xl font-bold text-slate-800 text-center mb-4">{{ $clinic->name }}</p>
                    <div class="space-y-2 text-center text-sm">
                        <p class="text-slate-600">
                            <span class="font-medium">عدد المرضى في الانتظار:</span>
                            <span class="font-bold text-slate-800" data-waiting>{{ $waiting }}</span>
                        </p>
                        <p class="text-slate-600">
                            <span class="font-medium">رقم المريض الحالي:</span>
                            <span class="font-bold text-slate-800" data-current>{{ $clinic->current_serving }}</span>
                        </p>
                    </div>
                    <a href="{{ route('ticket.show', $clinic) }}" target="_blank"
                       class="staff-issue-ticket mt-4 block w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-center shadow">
                        إصدار تذكرة (الرقم الجديد)
                    </a>
                </div>
            @endforeach
        </div>

    </div>
    <script>
        function updateStaffCards() {
            fetch('/api/clinics')
                .then(function (r) { return r.json(); })
                .then(function (clinics) {
                    clinics.forEach(function (c) {
                        var card = document.querySelector('[data-clinic-id="' + c.id + '"]');
                        if (card) {
                            card.querySelector('[data-waiting]').textContent = c.waiting;
                            card.querySelector('[data-current]').textContent = c.current_serving;
                        }
                    });
                });
        }
        setInterval(updateStaffCards, 1500);
        window.addEventListener('message', function (e) {
            if (e.data && e.data.type === 'ticket-issued' && e.data.clinicId) {
                updateStaffCards();
            }
        });
    </script>
</body>
</html>
