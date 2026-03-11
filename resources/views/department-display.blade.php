<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شاشة الانتظار - {{ $type }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .card-number { font-size: min(12vw, 5rem); }
        #call-overlay {
            transition: opacity 0.3s ease;
        }
        #call-overlay.hidden { opacity: 0; pointer-events: none; }
    </style>
</head>
<body class="min-h-screen p-4 md:p-6">
    {{-- overlay يعرض الرقم المستدعى كبيراً لثوانٍ --}}
    <div id="call-overlay" class="hidden fixed inset-0 z-50 flex flex-col items-center justify-center bg-black/70" aria-hidden="true">
        <div class="bg-white rounded-3xl shadow-2xl p-12 md:p-16 text-center max-w-4xl mx-4">
            <p id="call-overlay-dept" class="text-2xl md:text-3xl font-bold text-amber-600 mb-4"></p>
            <p id="call-overlay-number" class="text-[20vw] md:text-[15rem] font-black text-slate-800 leading-none" style="font-size: min(25vw, 18rem);"></p>
            <p class="text-xl text-slate-600 mt-4">تم استدعاؤك — توجه للقسم</p>
            <p class="text-slate-500 text-sm mt-1">You have been called — proceed to the department</p>
        </div>
    </div>

    <h1 class="text-slate-800 text-center text-xl md:text-2xl mb-1 font-bold">منطقة الانتظار - الأرقام الحالية لـ {{ $departmentTitle ?? 'الأقسام' }}</h1>
    <p class="text-slate-500 text-center text-sm mb-6">Waiting Area — Current numbers for {{ $departmentTitleEn ?? 'Departments' }}</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 max-w-7xl mx-auto" id="dept-display-cards">
        @foreach($departments as $dept)
            <div class="bg-white/95 rounded-xl p-6 border-2 border-amber-200 shadow-lg flex flex-col items-center justify-center min-h-[180px]" data-department-id="{{ $dept->id }}">
                <p class="text-amber-600 font-bold card-number" data-current>{{ $dept->current_serving }}</p>
                <p class="text-slate-800 text-lg md:text-xl font-semibold mt-3 text-center">{{ $dept->name }}</p>
                @if($dept->name_en)
                    <p class="text-slate-500 text-sm text-center mt-1">{{ $dept->name_en }}</p>
                @endif
                <p class="text-slate-600 text-sm mt-1">
                    من <span data-total>{{ $dept->patient_number }}</span> تذكرة
                </p>
                <p class="text-slate-500 text-xs mt-0.5">From <span data-total-en>{{ $dept->patient_number }}</span> ticket(s)</p>
            </div>
        @endforeach
    </div>
    <p class="text-slate-600 text-center text-sm mt-6">{{ setting('hospital_name', 'مستشفى الملك عبد العزيز التخصصي بالجوف') }} — التحديث تلقائي كل ثانية ونصف</p>
    <p class="text-slate-500 text-center text-xs mt-1">{{ setting('hospital_name', 'King Abdulaziz Specialist Hospital Al-Jouf') }} — Auto-refresh every 1.5 seconds</p>
    <p class="text-center mt-2">
        <button type="button" onclick="window.playCallSound && window.playCallSound()" class="px-4 py-2 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg">تشغيل نغمة تجريبية / Play test sound</button>
    </p>
    <script>
        (function() {
            var deptType = @json($type);
            var prev = {};
            function playCallSound() {
                try {
                    var C = window.AudioContext || window.webkitAudioContext;
                    if (!C) return;
                    var ctx = new C();
                    var dur = 0.28;
                    var gap = 0.12;
                    function chime(freq, startAt) {
                        var o = ctx.createOscillator();
                        var g = ctx.createGain();
                        o.connect(g);
                        g.connect(ctx.destination);
                        o.frequency.value = freq;
                        o.type = 'sine';
                        g.gain.setValueAtTime(0, startAt);
                        g.gain.linearRampToValueAtTime(0.25, startAt + 0.02);
                        g.gain.exponentialRampToValueAtTime(0.01, startAt + dur);
                        o.start(startAt);
                        o.stop(startAt + dur);
                    }
                    chime(523, ctx.currentTime);
                    chime(784, ctx.currentTime + dur + gap);
                } catch (e) {}
            }
            window.playCallSound = playCallSound;
            var overlayTimeout = null;
            function showCallOverlay(name, number) {
                var overlay = document.getElementById('call-overlay');
                document.getElementById('call-overlay-dept').textContent = name;
                document.getElementById('call-overlay-number').textContent = number;
                overlay.classList.remove('hidden');
                if (overlayTimeout) clearTimeout(overlayTimeout);
                overlayTimeout = setTimeout(function() {
                    overlay.classList.add('hidden');
                    overlayTimeout = null;
                }, 5000);
            }
            setInterval(function() {
                fetch('/api/departments?type=' + encodeURIComponent(deptType))
                    .then(function(r) { return r.json(); })
                    .then(function(list) {
                        var played = false;
                        list.forEach(function(d) {
                            var oldVal = prev[d.id];
                            if (oldVal !== undefined && d.current_serving > oldVal && d.current_serving > 0) {
                                played = true;
                                showCallOverlay(d.name, d.current_serving);
                            }
                            prev[d.id] = d.current_serving;
                            var card = document.querySelector('#dept-display-cards [data-department-id=\"' + d.id + '\"]');
                            if (card) {
                                card.querySelector('[data-current]').textContent = d.current_serving;
                                var totalEl = card.querySelector('[data-total]');
                                var totalEnEl = card.querySelector('[data-total-en]');
                                if (totalEl) totalEl.textContent = d.patient_number;
                                if (totalEnEl) totalEnEl.textContent = d.patient_number;
                            }
                        });
                        if (played) playCallSound();
                    });
            }, 1500);
        })();
    </script>
</body>
</html>

