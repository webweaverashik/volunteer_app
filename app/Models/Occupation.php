<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occupation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bn',
        'slug',
        'order',
    ];

    public function volunteers(): HasMany
    {
        return $this->hasMany(Volunteer::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name_bn');
    }
}
