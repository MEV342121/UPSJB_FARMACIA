<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('roles')]
#[Fillable(['nombre', 'descripcion'])]
class Rol extends Model
{
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}