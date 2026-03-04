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
            background-image: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)), url('{{ asset("images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen p-6 flex items-center justify-center">
    @if($clinic)
        <div class="max-w-md w-full bg-white/95 rounded-2xl shadow-xl p-8 border-2 border-amber-200">
            <h1 class="text-xl font-bold text-center text-slate-800 mb-2">متابعة التذكرة</h1>
            <p class="text-center text-amber-600 font-semibold text-lg mb-6">{{ $clinic->name }}</p>

            <div class="space-y-4 text-lg">
                <p class="flex justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">رقمك:</span>
                    <span class="font-bold text-slate-800">{{ $yourNumber }}</span>
                </p>
                <p class="flex justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">الحالي عند الطبيب:</span>
                    <span class="font-bold text-amber-600">{{ $currentServing }}</span>
                </p>
                <p class="flex justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">قدامك:</span>
                    <span class="font-bold text-slate-800">{{ $ahead }} {{ $ahead === 1 ? 'شخص' : 'أشخاص' }}</span>
                </p>
            </div>

            @if($yourNumber <= $currentServing && $currentServing > 0)
                <p class="mt-6 text-center text-green-600 font-bold">تم استدعاؤك — توجه للعيادة</p>
            @endif

            <p class="text-slate-500 text-center text-sm mt-6">التحديث تلقائي كل 10 ثوانٍ</p>
        </div>
    @else
        <div class="bg-white/95 rounded-xl p-8 text-center max-w-sm">
            <p class="text-slate-600">رابط غير صالح أو انتهت صلاحية التذكرة.</p>
        </div>
    @endif
</body>
</html>
