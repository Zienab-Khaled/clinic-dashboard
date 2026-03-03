<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    /**
     * العيادات الافتراضية - مستشفى الملك عبد العزيز التخصصي بالجوف
     */
    public function run(): void
    {
        $clinics = [
            'رمد',
            'انف واذن وحنجرة',
            'اسنان',
            'جلديه',
            'صدرية',
            'عظام',
        ];

        foreach ($clinics as $name) {
            Clinic::firstOrCreate(
                ['name' => $name],
                [
                    'created_at' => now(),
                    'patient_number' => 0,
                ]
            );
        }
    }
}
