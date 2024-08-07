<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ListPendingMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrations:pending';
    protected $description = 'List all pending migrations';

    /**
     * Execute the console command.
     */

     public function __construct()
     {
         parent::__construct();
     }
 
    public function handle()
    {
        $migrations = DB::table('migrations')->pluck('migration');
        $migrationFiles = collect(glob(database_path('migrations') . '/*.php'))
            ->map(function ($file) {
                return pathinfo($file, PATHINFO_FILENAME);
            });

        $pendingMigrations = $migrationFiles->diff($migrations);

        $this->info('Pending Migrations:');
        foreach ($pendingMigrations as $migration) {
            $this->line($migration);
        }
    
    }

}