<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delay extends Model
{
    use HasFactory;

    protected $with = [
        'task'
    ];

    protected $fillable = [
        'task_id',
        'description',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
