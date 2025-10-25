<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DriverDocument extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'driver_id',
        'type',
        'number',
        'country',
        'from',
        'to',
        'meta',
    ];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'meta' => 'array',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(DocumentFile::class, 'document_id');
    }

    public function currentFile(): HasOne
    {
        return $this->hasOne(DocumentFile::class, 'document_id')
                    ->where('is_current', true);
    }

    public function getStatusAttribute(): string
    {
        if (! $this->to) {
            return 'no_data';
        }

        $daysUntilExpiry = Carbon::now()->diffInDays($this->to, false);

        if ($daysUntilExpiry < 0) {
            return 'expired';
        }

        if ($daysUntilExpiry <= 30) {
            return 'expiring_soon';
        }

        if ($daysUntilExpiry <= 60) {
            return 'warning';
        }

        return 'valid';
    }

    public function getDaysUntilExpiryAttribute(): ?int
    {
        if (! $this->to) {
            return null;
        }

        return Carbon::now()->diffInDays($this->to, false);
    }
}
