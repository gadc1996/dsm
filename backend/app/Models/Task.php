<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $with = [
        'created_by',
        'assigned_to',
    ];

    protected $fillable = [
        'description',
        'created_by_id',
        'assigned_to_id',
        'completation_date',
        'is_completed'
    ];

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    protected $appends = [
        'status_display'
    ];

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function assigned_to(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id', 'id');
    }

    public function scopeCurrent($query)
    {
        $query->whereDate('completation_date', now());
    }

    public function scopePending($query)
    {
        $query->whereDate('completation_date', '>', now());
    }

    public function scopeIncomplete($query)
    {
        $query->where('is_completed', false);
    }

    public function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_completed ? 'Finalizada' : 'En Curso'
        );
    }
}
