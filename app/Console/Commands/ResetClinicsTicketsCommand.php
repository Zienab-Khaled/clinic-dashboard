<?php

namespace App\Console\Commands;

use App\Models\Clinic;
use Illuminate\Console\Command;

class ResetClinicsTicketsCommand extends Command
{
    protected $signature = 'clinics:reset-tickets';

    protected $description = 'إعادة تعيين أرقام مرضى العيادات (التذاكر) إلى صفر';

    public function handle(): int
    {
        Clinic::query()->update(['patient_number' => 0, 'current_serving' => 0]);

        $this->info('تم تصفير أرقام المرضى لجميع العيادات.');

        return self::SUCCESS;
    }
}
