<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Invoice extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['client_id', 'project_id'];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function (Invoice $invoice) {
            $invoice->status = InvoiceStatus::DRAFT;
            $invoice->uid = uniqid();
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
