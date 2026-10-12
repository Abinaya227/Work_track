<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('manager_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('review_period_start');
            $table->date('review_period_end');
            $table->unsignedTinyInteger('rating');
            $table->text('comments')->nullable();

            $table->timestamps();

            $table->index(['employee_id', 'review_period_start']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
