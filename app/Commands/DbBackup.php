<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class DbBackup extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:backup';
    protected $description = 'Backup the database to a SQL file.';

    public function run(array $params)
    {
        // Load the database configuration
        $db = Database::connect();

        // Get the database name
        $databaseName = $db->getDatabase();

        // Check if --no-data option is present
        $noData = CLI::getOption('no-data') !== null;

        // Construct the backup filename
        $suffix = $noData ? '_no_data' : '';
        $backupFileName = $databaseName . '_backup_' . date('Y-m-d_H-i-s') . $suffix . '.sql';
        $backupPath = WRITEPATH . 'backups/' . $backupFileName;

        // Make sure the backup directory exists
        if (!is_dir(WRITEPATH . 'backups')) {
            mkdir(WRITEPATH . 'backups', 0777, true);
        }

        // Generate the mysqldump command
        $command = 'mysqldump --triggers --user=' . $db->username . ' --password=' . $db->password . ' --host=' . $db->hostname . ' ';

        if ($noData) {
            $command .= '--no-data ';
        }

        $command .= $databaseName . ' > ' . $backupPath;

        // Execute the command
        $output = null;
        $result = system($command, $output);

        // Check for errors
        if ($result === false) {
            CLI::error('Database backup failed.');
            return;
        }

        CLI::write('Database backup saved to: ' . $backupPath, 'green');
    }
}
