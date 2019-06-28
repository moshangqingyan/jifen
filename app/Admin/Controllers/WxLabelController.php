<?php

namespace App\Admin\Controllers;

use App\Model\WxLabel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WxLabelController extends Controller
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
        return Admin::grid(WxLabel::class, function (Grid $grid) {

            $grid->column('id', __('Id'));
            $grid->column('name', __('标签名字'));
            $grid->imgurl('标签')->display(function ($imgurl) {
                return '<img src = "' . $imgurl . '" //>';
            });
            $grid->column('created_at', __('创建时间'));
            $grid->column('updated_at', __('修改时间'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        return Admin::form(WxLabel::class, function (Form $form) {

            $form->text('name', __('标签名字'));

            $form->image('imgurl')->name(function ($file) {
                return time() . '.' . $file->guessExtension();
            });
            $form->saved(function (Form $form) {
                $this->show($form->model()->id);
            });
        });
    }
}
