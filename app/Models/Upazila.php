<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upazila extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bn',
        'slug',
        'is_sylhet3',
        'order',
    ];

    protected $casts = [
        'is_sylhet3' => 'boolean',
    ];

    public function volunteers(): HasMany
    {
        return $this->hasMany(Volunteer::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name_bn');
    }

    public function scopeSylhet3($query)
    {
        return $query->where('is_sylhet3', true);
    }
}
