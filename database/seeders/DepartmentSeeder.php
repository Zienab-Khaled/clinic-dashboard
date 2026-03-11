<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['type' => 'emergency', 'name' => 'طوارئ رجال', 'name_en' => 'Emergency Men'],
            ['type' => 'emergency', 'name' => 'طوارئ نساء', 'name_en' => 'Emergency Women'],
            ['type' => 'diabetes', 'name' => 'عيادة سكر رجال', 'name_en' => 'Diabetes Clinic Men'],
            ['type' => 'diabetes', 'name' => 'عيادة سكر نساء', 'name_en' => 'Diabetes Clinic Women'],
            ['type' => 'radiology', 'name' => 'XR', 'name_en' => 'X-Ray'],
            ['type' => 'radiology', 'name' => 'CT', 'name_en' => 'CT'],
            ['type' => 'radiology', 'name' => 'MR', 'name_en' => 'MRI'],
            ['type' => 'radiology', 'name' => 'US', 'name_en' => 'Ultrasound'],
            ['type' => 'radiology', 'name' => 'FL', 'name_en' => 'Fluoroscopy'],
            ['type' => 'radiology', 'name' => 'MA', 'name_en' => 'Mammography'],
            ['type' => 'pharmacy', 'name' => 'الصيدلية', 'name_en' => 'Pharmacy'],
            ['type' => 'lab', 'name' => 'مختبر رجال', 'name_en' => 'Lab Men'],
            ['type' => 'lab', 'name' => 'مختبر نساء', 'name_en' => 'Lab Women'],
        ];

        foreach ($items as $item) {
            $nameEn = $item['name_en'] ?? null;
            unset($item['name_en']);
            Department::firstOrCreate(
                ['type' => $item['type'], 'name' => $item['name']],
                [
                    'name_en' => $nameEn,
                    'patient_number' => 0,
                    'current_serving' => 0,
                ]
            );
        }
    }
}
