<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شاشة الطبيب - استدعاء المرضى</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('{{ asset(setting("background_image") ?? "images/background.jpg") }}');
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
            <label class="block text-base font-semibold text-slate-700 mb-3">اختر العيادة</label>
            <select name="clinic_id"
                    onchange="this.form.submit()"
                    class="w-full py-4 px-4 text-lg font-medium text-slate-800 bg-white border-2 border-amber-400 rounded-xl shadow-md hover:border-amber-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none cursor-pointer appearance-none"
                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%236b7280%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25rem; padding-right: 2.75rem;">
                <option value="">-- اختر العيادة --</option>
                @foreach($clinics as $c)
                    <option value="{{ $c->id }}" {{ $clinic && $clinic->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </form>

        @if($clinic)
            <div class="bg-white/95 rounded-lg shadow p-6 mb-6" id="doctor-clinic-card" data-clinic-id="{{ $clinic->id }}">
                <p class="text-gray-600">عدد المرضى الحاصلين على تذاكر: <strong class="text-xl" id="doctor-patient-number">{{ $clinic->patient_number }}</strong></p>
                <p class="text-gray-600 mt-2">الرقم الحالي المُستدعى: <strong class="text-xl" id="doctor-current-serving">{{ $clinic->current_serving }}</strong></p>
                <form method="post" action="{{ route('doctor.next', $clinic) }}" class="mt-4" id="doctor-next-form">
                    @csrf
                    <button type="submit" id="doctor-next-btn"
                            class="w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $clinic->current_serving >= $clinic->patient_number ? 'disabled' : '' }}>
                        استدعاء التالي
                    </button>
                    <p class="text-sm text-gray-500 mt-2" id="doctor-next-msg">
                        @if($clinic->current_serving >= $clinic->patient_number && $clinic->patient_number > 0)
                            تم استدعاء آخر مريض
                        @elseif($clinic->patient_number === 0)
                            لا يوجد مرضى في الانتظار
                        @endif
                    </p>
                </form>
            </div>
            <div class="bg-amber-50/95 border border-amber-200 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-600">يُعرض الآن في منطقة الانتظار:</p>
                <p class="text-4xl font-bold mt-2" id="doctor-display-number">{{ $clinic->current_serving }}</p>
                <p class="text-xl font-semibold">{{ $clinic->name }}</p>
            </div>
            {{-- <p class="text-center mt-4">
                <a href="{{ route('display') }}" target="_blank" class="text-amber-600 hover:underline">فتح شاشة العرض (منطقة الانتظار)</a>
            </p> --}}
            <script>
                (function() {
                    var clinicId = {{ $clinic->id }};
                    var token = document.querySelector('#doctor-next-form input[name="_token"]').value;

                    function updateDoctorCard(data) {
                        document.getElementById('doctor-patient-number').textContent = data.patient_number;
                        document.getElementById('doctor-current-serving').textContent = data.current_serving;
                        document.getElementById('doctor-display-number').textContent = data.current_serving;
                        var btn = document.getElementById('doctor-next-btn');
                        var msg = document.getElementById('doctor-next-msg');
                        if (data.current_serving >= data.patient_number) {
                            btn.disabled = true;
                            msg.textContent = data.patient_number > 0 ? 'تم استدعاء آخر مريض' : 'لا يوجد مرضى في الانتظار';
                        } else {
                            btn.disabled = false;
                            msg.textContent = '';
                        }
                    }

                    setInterval(function() {
                        fetch('/api/clinics/' + clinicId)
                            .then(function(r) { return r.json(); })
                            .then(updateDoctorCard);
                    }, 2000);

                    document.getElementById('doctor-next-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': token
                            },
                            body: '_token=' + encodeURIComponent(token)
                        })
                        .then(function(r) { return r.json(); })
                        .then(updateDoctorCard);
                    });
                })();
            </script>
        @endif

    </div>
</body>
</html>
