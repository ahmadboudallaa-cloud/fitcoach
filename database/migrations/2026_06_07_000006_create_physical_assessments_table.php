<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('physical_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('coach_id')->constrained('users')->cascadeOnDelete();
            $table->date('assessment_date');
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('body_fat', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_assessments');
    }
};
