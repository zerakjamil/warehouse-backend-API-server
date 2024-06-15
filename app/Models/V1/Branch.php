<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'profile_logo',
        'address',
        'warehouse_id'
    ];
    public $timestamps = false;
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
