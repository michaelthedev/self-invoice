<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Client extends Model
{
    protected $guarded = ['id'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
