<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
