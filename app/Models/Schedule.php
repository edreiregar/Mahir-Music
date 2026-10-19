<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'user_id', 'student_name', 'schedule_date', 'schedule_time', 'material_file', 'attendance',
    ];

    protected function casts(): array
    {
        return ['schedule_date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function timeLabel(): string
    {
        return substr((string) $this->schedule_time, 0, 5);
    }
}
