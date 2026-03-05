<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شاشة الموظف - {{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .card-dept { transition: transform 0.2s, box-shadow 0.2s; }
        .card-dept:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1); }
    </style>
</head>
<body class="min-h-screen p-4 md:p-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 mb-8">
            <img src="{{ asset('images/logo.jpg') }}" alt="شعار المستشفى" class="w-16 h-16 md:w-20 md:h-20 object-contain rounded-lg" onerror="this.style.display='none'">
            <div class="text-center md:text-right">
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">شاشة الموظف - {{ $title }}</h1>
                <p class="text-slate-600 mt-1">اختر التصنيف لإصدار تذكرة</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg">الرئيسية</a>
                <form action="{{ route('department.reset', $type) }}" method="post" class="inline" onsubmit="return confirm('إعادة تعيين أرقام {{ $title }}؟');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg">إعادة تعيين</button>
                </form>
            </div>
        </div>

        @if(session('message'))
            <p class="text-center text-green-600 font-medium mb-4">{{ session('message') }}</p>
        @endif

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
            @foreach($departments as $index => $dept)
                @php
                    $colorClass = $colors[$colorKeys[$index % count($colors)]];
                    $waiting = $dept->patient_number - $dept->current_serving;
                @endphp
                <div class="card-dept rounded-xl border-2 {{ $colorClass }} p-5 shadow-md bg-white/95" data-department-id="{{ $dept->id }}">
                    <p class="text-xl font-bold text-slate-800 text-center mb-4">{{ $dept->name }}</p>
                    <div class="space-y-2 text-center text-sm">
                        <p class="text-slate-600">
                            <span class="font-medium">في الانتظار:</span>
                            <span class="font-bold text-slate-800" data-waiting>{{ $waiting }}</span>
                        </p>
                        <p class="text-slate-600">
                            <span class="font-medium">الحالي:</span>
                            <span class="font-bold text-slate-800" data-current>{{ $dept->current_serving }}</span>
                        </p>
                    </div>
                    <a href="{{ route('department.ticket.show', $dept) }}" target="_blank"
                       class="dept-issue-ticket mt-4 block w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-center shadow">
                        إصدار تذكرة
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        var deptType = @json($type);
        function updateDeptCards() {
            fetch('/api/departments?type=' + encodeURIComponent(deptType))
                .then(function (r) { return r.json(); })
                .then(function (list) {
                    list.forEach(function (d) {
                        var card = document.querySelector('[data-department-id="' + d.id + '"]');
                        if (card) {
                            card.querySelector('[data-waiting]').textContent = d.waiting;
                            card.querySelector('[data-current]').textContent = d.current_serving;
                        }
                    });
                });
        }
        setInterval(updateDeptCards, 1500);
        window.addEventListener('message', function (e) {
            if (e.data && e.data.type === 'ticket-issued-dept' && e.data.departmentId) {
                updateDeptCards();
            }
        });
    </script>
</body>
</html>
