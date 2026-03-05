<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متابعة التذكرة</title>
    <meta http-equiv="refresh" content="10">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen p-6 flex items-center justify-center">
    @php $location = $clinic ?? $department; $locationName = $clinic ? $clinic->name : ($department ? $department->name : null); $currentLabel = $clinic ? 'الحالي عند الطبيب' : 'الحالي'; $calledMsg = $clinic ? 'توجه للعيادة' : 'توجه للقسم'; @endphp
    @if($location)
        <div class="max-w-md w-full bg-white/95 rounded-2xl shadow-xl p-8 border-2 border-amber-200">
            <h1 class="text-xl font-bold text-center text-slate-800 mb-2">متابعة التذكرة</h1>
            <p class="text-center text-amber-600 font-semibold text-lg mb-6">{{ $locationName }}</p>

            <div class="space-y-4 text-lg">
                <p class="flex justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">رقمك:</span>
                    <span class="font-bold text-slate-800">{{ $yourNumber }}</span>
                </p>
                <p class="flex justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">{{ $currentLabel }}:</span>
                    <span class="font-bold text-amber-600">{{ $currentServing }}</span>
                </p>
                <p class="flex justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">قدامك:</span>
                    <span class="font-bold text-slate-800">{{ $ahead }} {{ $ahead === 1 ? 'شخص' : 'أشخاص' }}</span>
                </p>
            </div>

            @if($yourNumber <= $currentServing && $currentServing > 0)
                <p class="mt-6 text-center text-green-600 font-bold" id="called-msg">تم استدعاؤك — {{ $calledMsg }}</p>
            @endif

            <p class="text-slate-500 text-center text-sm mt-6">التحديث تلقائي كل 10 ثوانٍ</p>
    @if($location && $yourNumber <= $currentServing && $currentServing > 0)
            <script>
                (function() {
                    var key = 'called-sound-{{ $location->id }}-{{ $yourNumber }}';
                    if (!sessionStorage.getItem(key)) {
                        sessionStorage.setItem(key, '1');
                        try {
                            var C = window.AudioContext || window.webkitAudioContext;
                            if (C) {
                                var ctx = new C();
                                var dur = 0.28, gap = 0.12;
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
                            }
                        } catch (e) {}
                    }
                })();
            </script>
    @endif
        </div>
    @else
        <div class="bg-white/95 rounded-xl p-8 text-center max-w-sm">
            <p class="text-slate-600">رابط غير صالح أو انتهت صلاحية التذكرة.</p>
        </div>
    @endif
</body>
</html>
