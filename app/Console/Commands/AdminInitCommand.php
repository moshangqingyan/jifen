<?php

namespace App\Console\Commands;

use Encore\Admin\Commands\InstallCommand;

class AdminInitCommand extends InstallCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init the laravel-admin';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->publishDatabase();

        $this->initAdminDirectory();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function publishDatabase()
    {
        $this->call('migrate', ['--path' => '/vendor/encore/laravel-admin/migrations/']);

        $this->call('db:seed', ['--class' => \AdminTablesSeeder::class]);
        // 自定义菜单
        $this->call('db:seed', ['--class' => \AdminMenuSeeder::class]);
        // 发布资源
        $this->call('vendor:publish', ['--tag' => 'laravel-admin']);
    }

    /**
     * Initialize the admin directory.
     *
     * @return void
     */
    protected function initAdminDirectory()
    {
        $this->directory = config('admin.directory');

        if (is_dir($this->directory)) {
            $this->line("<info>{$this->directory} directory already exists ! Will skip to init the directory and files!</info> ");

            return;
        }

        $this->makeDir('/');
        $this->line('<info>Admin directory was created:</info> ' . str_replace(base_path(), '', $this->directory));

        $this->makeDir('Controllers');

        $this->createHomeController();
        $this->createExampleController();
        //$this->createAuthController();
        //$this->createAdministratorController();

        //$this->createMenuFile();
        $this->createBootstrapFile();
        $this->createRoutesFile();

        //$this->copyLanguageFiles();
    }
}
