<?php

declare(strict_types=1);

namespace App\Enums;

final readonly class InvoiceStatus
{
    public const string DRAFT = 'draft';
    public const string PAID = 'paid';
    public const string UNPAID = 'unpaid';
    public const string CANCELLED = 'cancelled';
}
