<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['cliente_id', 'user_id', 'fecha', 'total', 'igv'])]
class Venta extends Model
{
    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'total' => 'decimal:2',
            'igv' => 'decimal:2',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }

        // Los precios ya incluyen el IGV (18 %): se separa del total.
    public function calcularTotal(): float
    {
        $this->total = round($this->detalles()->sum('subtotal'), 2);
        $this->igv = round($this->total - $this->total / 1.18, 2);

        return (float) $this->total;
    }
}