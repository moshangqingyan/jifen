<?php

namespace App\Console\Commands;

use App\Model\PremiumCache;
use Faker\Provider\DateTime;
use Illuminate\Console\Command;

class PremiumCacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'premium:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Premium Cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expireDate = date('Y-m-d');
        $deleteRows = PremiumCache::where('START_DATE', '<', $expireDate)->delete();
        $this->info('共清理' . $deleteRows . '条' . $expireDate . '过期的缓存算价信息.');
    }
}
