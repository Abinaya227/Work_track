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
        Schema::create('daily_work_updates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->foreignId('employee_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('work_date');
            $table->text('completed_work');
            $table->text('pending_work')->nullable();
            $table->text('blockers')->nullable();
            $table->decimal('hours_spent', 5, 2)->default(0);

            $table->timestamps();

            $table->index(['employee_id', 'work_date']);
            $table->index(['task_id', 'work_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_work_updates');
    }
};
