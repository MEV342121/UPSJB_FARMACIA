<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'name', 'price', 'stock', 'image'])]
class Medicine extends Model
{
    // Un medicamento pertenece a una categoría
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Un medicamento aparece en muchos detalles de venta
    public function detailSales(): HasMany
    {
        return $this->hasMany(DetailSale::class);
    }
}
