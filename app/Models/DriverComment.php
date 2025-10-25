<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverComment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'driver_id',
        'author_id',
        'text',
        'attachment_file_id',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function attachment(): BelongsTo
    {
        return $this->belongsTo(DocumentFile::class, 'attachment_file_id');
    }
}
