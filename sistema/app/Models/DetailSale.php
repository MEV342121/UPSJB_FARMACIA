<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['sale_id', 'medicine_id', 'amount', 'price_unit', 'subtotal'])]
class DetailSale extends Model
{
    // El detalle pertenece a una venta
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    // El detalle es de un medicamento
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
