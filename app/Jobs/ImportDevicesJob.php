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
        if (!file_exists($this->filePath)) {
            Log::error("File not found: " . $this->filePath);
            return;
        }

        try {
            $handle = fopen($this->filePath, 'r');
            if (!$handle) {
                Log::error("Could not open file: " . $this->filePath);
                return;
            }

            // Skip the first line (header)
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                Device::create([
                    'id' => $data[0],
                    'serial_number' => $data[1],
                    'mac_address' => $data[2],
                    'branch_id' => $data[3],
                    'registered_at' => $data[4],
                    'sold_at' => $data[5],
                    'box_number' => $data[6],
                ]);
            }

            fclose($handle);

            // Delete the file after processing
            unlink($this->filePath);
        } catch (\Exception $e) {
            Log::error("Error importing devices from file: " . $e->getMessage());
        }
    }
}
