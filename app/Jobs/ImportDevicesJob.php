<?php
namespace App\Jobs;

use App\Models\V1\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportDevicesJob implements ShouldQueue
{
use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

protected $filePath;

public function __construct($filePath)
{
$this->filePath = $filePath;
}

public function handle()
{
try {
if (!file_exists($this->filePath)) {
Log::error("File not found: " . $this->filePath);
return;
}

$handle = fopen($this->filePath, 'r');
if (!$handle) {
Log::error("Could not open file: " . $this->filePath);
return;
}

fgetcsv($handle);

    while (($data = fgetcsv($handle, 1001, ',')) !== false) {
        if (count($data) < 7) {
            Log::warning("Incomplete row at line " . implode(", ", $data));
            continue;
        }
        Device::create([
            'id' => (int)$data[0],
            'serial_number' => $data[1],
            'mac_address' => $data[2],
            'branch_id' => (int)$data[3],
            'registered_at' => $data[4],
            'sold_at' => $data[5] ?: null,
            'box_number' => $data[6],
        ]);
    }
fclose($handle);

unlink($this->filePath);
    } catch (\Exception $e) {
    Log::error("Error importing devices from file: " . $e->getMessage());
    }
}
}
