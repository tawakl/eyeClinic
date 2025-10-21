<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clinic_working_days', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->time('break_from')->nullable();
            $table->time('break_to')->nullable();
            $table->integer('slot_duration')->default(15); // minutes
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_working_days');
    }
};
