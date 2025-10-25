<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'internal_number',
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'citizenship',
        'rodne_cislo',
        'email',
        'phone',
        'reg_address',
        'res_address',
        'status',
        'hire_date',
        'fire_date',
        'contract_from',
        'contract_to',
        'contract_indefinite',
        'work_location',
        'bank_country',
        'bank_account',
        'iban',
        'swift',
        'flags',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'fire_date' => 'date',
        'contract_from' => 'date',
        'contract_to' => 'date',
        'contract_indefinite' => 'boolean',
        'flags' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($driver) {
            if (! $driver->internal_number) {
                $driver->internal_number = \DB::selectOne(
                    "SELECT nextval('drivers_internal_number_seq') as next"
                )->next;
            }
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DriverDocument::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(DriverComment::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }
}
