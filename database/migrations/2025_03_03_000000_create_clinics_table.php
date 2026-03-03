<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('patient_number')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
