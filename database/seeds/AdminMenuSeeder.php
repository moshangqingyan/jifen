<?php

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Menu;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add menu
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'api用户',
                'icon'      => 'fa-user',
                'uri'       => 'apiuser',
            ],
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '代理服务器',
                'icon'      => 'fa-server',
                'uri'       => 'proxy',
            ],
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '算价器',
                'icon'      => 'fa-instagram',
                'uri'       => 'insurance',
            ],
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '算价器账号',
                'icon'      => 'fa-archive',
                'uri'       => 'account',
            ],
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '接口',
                'icon'      => 'fa-unlink',
                'uri'       => 'interface',
            ],
        ]);
    }
}
