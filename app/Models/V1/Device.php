<?php
namespace App\Models\V1;

use App\Observers\DeviceObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(DeviceObserver::class)]
class Device extends Model
{
use HasFactory;

public $timestamps = false;

protected $fillable = [
'serial_number',
'warehouse_id',
'mac_address',
'branch_id',
'sold_at',
'registered_at',
'box_number',
];

public function branch(): BelongsTo
{
return $this->belongsTo(Branch::class);
}

public function warehouse(): BelongsTo
{
return $this->belongsTo(Warehouse::class);
}
}
