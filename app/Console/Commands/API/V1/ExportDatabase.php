<?php

namespace App\Console\Commands\API\V1;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabase extends Command
{
    protected $signature = 'db:export';

    protected $description = 'Export whole database into an SQL file';

    public function handle()
    {
        $fileName = storage_path('app/db-backup-' . date('Y-m-d_H-i-s') . '.sql');

        $databaseName = DB::connection()->getDatabaseName();
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$databaseName} > {$fileName}";
        exec($command);

        $this->info("Database exported to: {$fileName}");
    }
}
