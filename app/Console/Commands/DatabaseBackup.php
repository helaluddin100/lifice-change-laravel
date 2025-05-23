<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseBackup extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Take a backup of the database and store it in storage/backups';

    public function handle()
    {
        $db = config('database.connections.mysql');
        $database = $db['database'];
        $username = $db['username'];
        $password = $db['password'];
        $host = $db['host'];
        $timestamp = now()->format('Y-m-d_H-i-s');
        $backupPath = storage_path("backups/{$database}_backup_{$timestamp}.sql");

        // Ensure directory exists
        if (!File::exists(storage_path('backups'))) {
            File::makeDirectory(storage_path('backups'), 0755, true);
        }

        // Build the mysqldump command
        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$backupPath}";

        $returnVar = null;
        $output = null;

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Database backup successful: {$backupPath}");
        } else {
            $this->error("Database backup failed.");
        }
    }
}
