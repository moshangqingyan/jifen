<?php

namespace App\Console;

use App\Console\Commands\AdminInitCommand;
use App\Console\Commands\ClearPremiumCache;
use App\Console\Commands\PremiumCacheClear;
use App\Console\Commands\ProxyCheck;
use App\Console\Commands\SendLastWeekPremiumCountMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
//        ProxyCheck::class,
        AdminInitCommand::class,
        PremiumCacheClear::class,
        SendLastWeekPremiumCountMail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('proxy:check')->everyMinute();
        // 每天晚上12点清理过期的缓存
        $schedule->command('premium:clear')->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
