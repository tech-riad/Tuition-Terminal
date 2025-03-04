<?php

namespace App\Console\Commands;

use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Laravel log file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Clear the log file
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
            $this->info('Log file cleared.');
        } else {
            $this->info('No log file found to clear.');
        }

        // Clear caches
        Artisan::call('cache:clear');
        $this->info('Application cache cleared.');

        Artisan::call('config:clear');
        $this->info('Configuration cache cleared.');

        Artisan::call('route:clear');
        $this->info('Route cache cleared.');

        Artisan::call('view:clear');
        $this->info('View cache cleared.');

        Tutor::whereDate('boost_expire', '<=', Carbon::today())->update([
            'is_boost' => 0,
            'boost_date' => null,
            'boost_package' => null,
            'boost_expire' => null,
        ]);

        return 0;
    }
}
