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
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg">الرئيسية</a>
                @if($hasWaitingDisplay ?? false)
                <a href="{{ route('department.display', $type) }}" target="_blank" class="px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg">
                    عرض شاشة الانتظار للقسم
                </a>
                @endif
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
                    $nextNumber = $waiting > 0 ? $dept->current_serving + 1 : null;
                @endphp
                <div class="card-dept rounded-xl border-2 {{ $colorClass }} p-5 shadow-md bg-white/95" data-department-id="{{ $dept->id }}" data-waiting="{{ $waiting }}">
                    <p class="text-xl font-bold text-slate-800 text-center mb-4">{{ $dept->name }}</p>
                    @if($dept->name_en)
                        <p class="text-slate-500 text-sm text-center mb-2">{{ $dept->name_en }}</p>
                    @endif
                    <div class="space-y-2 text-center text-sm">
                        <p class="text-slate-600">
                            <span class="font-medium">عدد التذاكر:</span>
                            <span class="font-bold text-slate-800" data-total>{{ $dept->patient_number }}</span>
                        </p>
                        <p class="text-slate-600">
                            <span class="font-medium">المريض الحالي:</span>
                            <span class="font-bold text-slate-800" data-current>{{ $dept->current_serving }}</span>
                        </p>
                        <p class="text-slate-600">
                            <span class="font-medium">اللي عليه الدور (التالي):</span>
                            <span class="font-bold text-slate-800" data-next>{{ $nextNumber ?? '—' }}</span>
                        </p>
                    </div>
                    <a href="{{ route('department.ticket.show', $dept) }}" target="_blank"
                       class="dept-issue-ticket mt-4 block w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-center shadow">
                        إصدار تذكرة
                    </a>
                    @if($hasWaitingDisplay ?? false)
                    <form action="{{ route('department.next', $dept) }}" method="post" class="mt-2 dept-call-next-form">
                        @csrf
                        <button type="submit" class="dept-call-next-btn w-full py-2.5 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg text-center shadow text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-emerald-500" {{ $waiting <= 0 ? 'disabled' : '' }}>
                            استدعاء للمريض التالي
                        </button>
                    </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <script>
        var deptType = @json($type);
        function playCallSound() {
            try {
                var C = window.AudioContext || window.webkitAudioContext;
                if (!C) return;
                var ctx = new C();
                var dur = 0.28, gap = 0.12;
                function chime(freq, startAt) {
                    var o = ctx.createOscillator(), g = ctx.createGain();
                    o.connect(g); g.connect(ctx.destination);
                    o.frequency.value = freq; o.type = 'sine';
                    g.gain.setValueAtTime(0, startAt);
                    g.gain.linearRampToValueAtTime(0.25, startAt + 0.02);
                    g.gain.exponentialRampToValueAtTime(0.01, startAt + dur);
                    o.start(startAt); o.stop(startAt + dur);
                }
                chime(523, ctx.currentTime);
                chime(784, ctx.currentTime + dur + gap);
            } catch (e) {}
        }
        function updateDeptCards() {
            fetch('/api/departments?type=' + encodeURIComponent(deptType))
                .then(function (r) { return r.json(); })
                .then(function (list) {
                        list.forEach(function (d) {
                            var card = document.querySelector('[data-department-id="' + d.id + '"]');
                            if (card) {
                                card.setAttribute('data-waiting', d.waiting);
                                var totalEl = card.querySelector('[data-total]');
                                var currentEl = card.querySelector('[data-current]');
                                var nextEl = card.querySelector('[data-next]');
                                if (totalEl) totalEl.textContent = d.patient_number;
                                if (currentEl) currentEl.textContent = d.current_serving;
                                if (nextEl) nextEl.textContent = d.waiting > 0 ? (d.current_serving + 1) : '—';
                                var btn = card.querySelector('.dept-call-next-btn');
                                if (btn) btn.disabled = d.waiting <= 0;
                            }
                        });
                });
        }
        document.querySelectorAll('.dept-call-next-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (form.querySelector('.dept-call-next-btn').disabled) return;
                var fd = new FormData(form);
                fetch(form.action, { method: 'POST', body: fd })
                    .then(function () {
                        playCallSound();
                        updateDeptCards();
                    });
            });
        });
        setInterval(updateDeptCards, 1500);
        window.addEventListener('message', function (e) {
            if (e.data && e.data.type === 'ticket-issued-dept' && e.data.departmentId) {
                updateDeptCards();
            }
        });
    </script>
</body>
</html>
