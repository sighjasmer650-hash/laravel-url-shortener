<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'invited_by',
        'email',
        'role',
        'token',
        'status',
        'expires_at',
        'accepted_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function getRoleBadgeClass(): string
    {
        return match ($this->role) {
            'Admin'   => 'bg-danger-subtle text-danger',
            'Member'  => 'bg-primary-subtle text-primary',
            'Sales'   => 'bg-warning-subtle text-warning',
            'Manager' => 'bg-info-subtle text-info',
            default   => 'bg-secondary-subtle text-secondary',
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-warning-subtle text-warning',
            'accepted' => 'bg-success-subtle text-success',
            'expired'  => 'bg-danger-subtle text-danger',
            default    => 'bg-secondary-subtle text-secondary',
        };
    }
}