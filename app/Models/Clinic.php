<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'created_at',
        'patient_number',
        'current_serving',
    ];

    protected $casts = [
        'created_at' => 'datetime',
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
}
