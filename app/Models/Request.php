<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'priority',
        'due_date',
        'requested_by',
        'assigned_to',
    ];

    // Relations
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scope for “my requests”
    public function scopeMine(Builder $query): Builder
    {
        return $query->where('requested_by', auth()->id());
    }

    // Helper to check completion
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
