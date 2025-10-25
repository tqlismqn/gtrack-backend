<?php

namespace App\Models;

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
        'status',
        'days_until_expiry',
        'meta',
    ];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'days_until_expiry' => 'integer',
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

}
