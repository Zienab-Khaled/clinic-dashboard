<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'type',
        'name',
        'patient_number',
        'current_serving',
    ];

    protected $casts = [
        'patient_number' => 'integer',
        'current_serving' => 'integer',
    ];

    public function callNext(): bool
    {
        if ($this->current_serving >= $this->patient_number) {
            return false;
        }
        $this->increment('current_serving');
        return true;
    }

    public function generateTicketNumber(): int
    {
        $this->increment('patient_number');
        $this->refresh();
        return $this->patient_number;
    }

    public function getWaitingAttribute(): int
    {
        return $this->patient_number - $this->current_serving;
    }
}
