<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تقرير الإحصائيات - نظام إدارة العيادات - مستشفى الملك عبد العزيز التخصصي بالجوف</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: system-ui, sans-serif;
            margin: 1rem;
            color: #111;
            background-image: linear-gradient(rgba(255,255,255,0.72), rgba(255,255,255,0.72)), url('/images/background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .content-wrap { background: rgba(255,255,255,0.92); padding: 1rem; border-radius: 0.5rem; max-width: 42rem; }
        h1 { font-size: 1.25rem; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 0.5rem; }
        th, td { border: 1px solid #ddd; padding: 0.5rem 0.75rem; text-align: right; }
        th { background: #f5f5f5; font-weight: 600; }
        tr:nth-child(even) { background: #fafafa; }
        .meta { color: #666; font-size: 0.875rem; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <div class="content-wrap">
    <h1>تقرير الإحصائيات</h1>
    <p class="meta">نظام إدارة العيادات - مستشفى الملك عبد العزيز التخصصي بالجوف</p>
    <p class="meta">{{ now()->translatedFormat('l، d F Y - H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>اسم العيادة</th>
                <th>عدد المرضى</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clinics as $clinic)
                <tr>
                    <td>{{ $clinic->name }}</td>
                    <td>{{ number_format($clinic->patient_number) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">لا توجد عيادات.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="meta" style="margin-top: 1.5rem;">يمكنك إغلاق هذه النافذة بعد الطباعة.</p>
    </div>

    <script>
        window.onload = function () { window.print(); };
    </script>
</body>
</html>
