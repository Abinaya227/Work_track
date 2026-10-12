<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'created_by',
        'priority',
        'status',
        'start_date',
        'due_date',
        'completed_at',
    ];
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'due_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dailyUpdates(): HasMany
    {
        return $this->hasMany(DailyWorkUpdate::class);
    }
}
