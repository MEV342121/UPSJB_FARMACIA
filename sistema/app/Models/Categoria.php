<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nombre', 'descripcion'])]
class Categoria extends Model
{
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class);
    }
}