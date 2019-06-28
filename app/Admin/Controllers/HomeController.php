<?php

namespace App\Admin\Controllers;

use App\Admin\Repository\InsuranceCount;

use App\Http\Controllers\Controller;

use Encore\Admin\Layout\Content;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->description('Description...');
    }
}
