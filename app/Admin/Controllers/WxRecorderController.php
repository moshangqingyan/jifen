<?php

namespace App\Admin\Controllers;

use App\Model\WxRecorder;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WxRecorderController extends Controller
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

            $content->header('header');
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
        return Admin::grid(WxRecorder::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('open_id', __('Open id'));
            $grid->column('name', __('Name'));
//            $grid->column('type', __('Type'));
            $grid->type('类型')->display(function ($released) {
                $option = [
                    '1' => '每日',
                    '2' => '每月',
                    '3' => '每季',
                ];
                return array_get($option, $released, '已删除');
            });
            $grid->column('created_at', __('Created at'));
            $grid->column('updated_at', __('Updated at'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(WxRecorder::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('open_id', __('Open id'));
            $form->text('name', __('Name'));
            $option = [
                '1' => '每日',
                '2' => '每月',
                '3' => '每季',
            ];
            $form->select('type', __('Type'))->options($option);
//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
