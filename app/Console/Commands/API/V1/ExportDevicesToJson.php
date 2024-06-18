<?php

namespace App\Console\Commands\API\V1;

use App\Models\V1\Device;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportDevicesToJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:export-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all devices to a JSON file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $devices = Device::all();

        $jsonData = $devices->toJson(JSON_PRETTY_PRINT);

        $fileName = 'devices_export_' . date('Ymd_His') . '.json';

        $filePath = 'exports/' . $fileName;
        Storage::disk('local')->put($filePath, $jsonData);

        $this->info("Devices exported successfully. File stored at: storage/app/$filePath");

        return 0;
    }
}
