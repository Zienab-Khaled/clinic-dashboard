<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شاشة الطبيب - استدعاء المرضى</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset("images/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen p-6">
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-center mb-6">شاشة الطبيب</h1>

        <form method="get" action="{{ route('doctor.index') }}" class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">اختر العيادة</label>
            <select name="clinic_id" class="w-full rounded border-gray-300" onchange="this.form.submit()">
                <option value="">-- اختر العيادة --</option>
                @foreach($clinics as $c)
                    <option value="{{ $c->id }}" {{ $clinic && $clinic->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </form>

        @if($clinic)
            <div class="bg-white/95 rounded-lg shadow p-6 mb-6">
                <p class="text-gray-600">عدد المرضى الحاصلين على تذاكر: <strong class="text-xl">{{ $clinic->patient_number }}</strong></p>
                <p class="text-gray-600 mt-2">الرقم الحالي المُستدعى: <strong class="text-xl">{{ $clinic->current_serving }}</strong></p>
                <form method="post" action="{{ route('doctor.next', $clinic) }}" class="mt-4">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $clinic->current_serving >= $clinic->patient_number ? 'disabled' : '' }}>
                        استدعاء التالي
                    </button>
                    @if($clinic->current_serving >= $clinic->patient_number && $clinic->patient_number > 0)
                        <p class="text-sm text-gray-500 mt-2">تم استدعاء آخر مريض</p>
                    @elseif($clinic->patient_number === 0)
                        <p class="text-sm text-gray-500 mt-2">لا يوجد مرضى في الانتظار</p>
                    @endif
                </form>
            </div>
            <div class="bg-amber-50/95 border border-amber-200 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-600">يُعرض الآن في منطقة الانتظار:</p>
                <p class="text-4xl font-bold mt-2">{{ $clinic->current_serving }}</p>
                <p class="text-xl font-semibold">{{ $clinic->name }}</p>
            </div>
            <p class="text-center mt-4">
                <a href="{{ route('display') }}" target="_blank" class="text-amber-600 hover:underline">فتح شاشة العرض (منطقة الانتظار)</a>
            </p>
        @endif

    </div>
</body>
</html>
