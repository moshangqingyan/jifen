<?php

namespace App\Admin\Controllers;

use App\Model\WxUser;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WxIntegralController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('积分统计');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(WxUser::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
//            $grid->column('account', __('户主'));
            $grid->column('account', '户主')->display(function () {
                return '<a href="/wxuser/' . $this->id . '">' . $this->account . '</a>';
            });
            $grid->column('population', __('人口数'));
            $grid->column('addr', __('家庭地址'));
            $grid->column('phone', __('联系电话'));
            $grid->integral()->display(function ($integral) {
                $sum = 0;
                foreach($integral as $item){
                    if ($item['created_at'] > date('Y') && $item['effective'] == '1') {
                        if ($item['is_add'] == '1') {
                            $sum += $item['grade'];
                        } else {
                            $sum -= $item['grade'];
                        }
                    }

                }
                return $sum;
//                return array_sum(array_map(function($val){return $val['grade'];}, $integral));

            });
            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->disableCreation();
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('account', '客户名称');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(WxUser::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
