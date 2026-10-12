<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DailyWorkUpdate extends Model
{
    protected $fillable = [
        'task_id',
        'employee_id',
        'work_date',
        'completed_work',
        'pending_work',
        'blockers',
        'hours_spent',
    ];

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'hours_spent' => 'decimal:2',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
