<?php

namespace App\Console\Commands\API\V1;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command

{

    /**

     * The name and signature of the console command.

     *

     * @var string

     */

    protected $signature = 'db:backup';

/**

 * The console command description.

 *

 * @var string

 */

protected $description = 'Automating Daily Backups';

/**

 * Execute the console command.

 */

public function handle()

{

    if (! Storage::exists('backup')) {
        Storage::makeDirectory('backup');
    }

    $fileName = 'backup-' . date('Y-m-d_H-i-s') . '.sql';
    $databaseName = DB::connection()->getDatabaseName();
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');
    $host = config('database.connections.mysql.host');
    $command = "mysqldump --user={$username} --password={$password} --host={$host} {$databaseName} >" . storage_path() . "/app/backup/{$fileName}";
    exec($command);

    $this->info("Database exported to: {$fileName}");
$returnVar = NULL;

$output = NULL;

exec($command, $output, $returnVar);

}

}
