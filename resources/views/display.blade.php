<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شاشة العرض - منطقة الانتظار</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset("images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .card-number { font-size: min(12vw, 5rem); }
    </style>
</head>
<body class="min-h-screen p-4 md:p-6">
    <h1 class="text-slate-800 text-center text-xl md:text-2xl mb-6 font-bold">منطقة الانتظار - الرقم الحالي لكل عيادة</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 max-w-7xl mx-auto" id="display-cards">
        @foreach($clinics as $clinic)
            <div class="bg-white/95 rounded-xl p-6 border-2 border-amber-200 shadow-lg flex flex-col items-center justify-center min-h-[180px]" data-clinic-id="{{ $clinic->id }}">
                <p class="text-amber-600 font-bold card-number" data-current>{{ $clinic->current_serving }}</p>
                <p class="text-slate-800 text-lg md:text-xl font-semibold mt-3 text-center">{{ $clinic->name }}</p>
                <p class="text-slate-600 text-sm mt-1">من <span data-total>{{ $clinic->patient_number }}</span> مريض</p>
            </div>
        @endforeach
    </div>
    <p class="text-slate-600 text-center text-sm mt-6">مستشفى الملك عبد العزيز التخصصي بالجوف — التحديث تلقائي كل ثانية ونصف</p>
    <p class="text-center mt-2">
        <button type="button" onclick="window.playCallSound && window.playCallSound()" class="px-4 py-2 text-sm bg-amber-500 hover:bg-amber-600 text-white rounded-lg">تشغيل نغمة تجريبية</button>
    </p>
    <script>
        (function() {
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
            setInterval(function() {
                fetch('/api/clinics')
                    .then(function(r) { return r.json(); })
                    .then(function(clinics) {
                        var played = false;
                        clinics.forEach(function(c) {
                            var oldVal = prev[c.id];
                            if (oldVal !== undefined && c.current_serving > oldVal && c.current_serving > 0) {
                                played = true;
                            }
                            prev[c.id] = c.current_serving;
                            var card = document.querySelector('#display-cards [data-clinic-id="' + c.id + '"]');
                            if (card) {
                                card.querySelector('[data-current]').textContent = c.current_serving;
                                card.querySelector('[data-total]').textContent = c.patient_number;
                            }
                        });
                        if (played) playCallSound();
                    });
            }, 1500);
        })();
    </script>
</body>
</html>
