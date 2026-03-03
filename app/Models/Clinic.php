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
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'patient_number' => 'integer',
    ];

    public function generateTicketNumber(): int
    {
        $this->increment('patient_number');
        $this->refresh();

        return $this->patient_number;
    }
}
