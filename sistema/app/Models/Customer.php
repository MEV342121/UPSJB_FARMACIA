<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'dni', 'phone', 'age'])]
class Customer extends Model
{
    // Un cliente tiene muchas ventas
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
