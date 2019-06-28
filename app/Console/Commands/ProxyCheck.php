<?php

namespace App\Console\Commands;

use App\Model\Proxy;
use Curl\Curl;
use Illuminate\Console\Command;

class ProxyCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:check {proxy?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Proxy Host Heart';

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
        $proxyId = $this->argument('proxy');

        if ($proxyId) {
            $proxy = Proxy::find($proxyId);
            $this->execCheck($proxy);
        } else {
            foreach (Proxy::all() as $item) {
                $this->execCheck($item);
            }
        }

        $this->line('proxy host check over');
    }

    protected function execCheck($proxy)
    {
        $url = 'http://' . $proxy->ip . ':' . $proxy->port;
        $curl = new Curl();
        $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 10); // 10秒连接超时
        $curl->get($url);
        $response = $curl->response;

        if ($curl->error || $response != 'ok') {
            $proxy->status = Proxy::STATUS_OFFLINE;
            $proxy->save();
            $this->line('proxy host ' . $proxy->name . $proxy->ip . ' is offline');
        } else {
            if ($proxy->status != Proxy::STATUS_ONLINE) {
                $proxy->status = Proxy::STATUS_ONLINE;
                $proxy->save();
            }
            $this->line('proxy host ' . $proxy->name . $proxy->ip . ' check success');
        }
    }
}
