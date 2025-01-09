<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class InvoiceItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'unit' => 'float',
        'quantity' => 'integer',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
