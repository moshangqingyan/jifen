<?php

namespace App\Admin\Controllers;

use App\Model\WxRecord;

use App\Model\WxRecorder;
use App\Model\WxUser;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WxRecordController extends Controller
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

            $content->header('打分记录');
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
        return Admin::grid(WxRecord::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
//            $grid->column('id', __('Id'));
//            $grid->column('user_id', __('农户姓名'));
//            $grid->column('recorder_id', __('记录人'));
            $grid->user_id('农户')->display(function($userId) {
                return WxUser::find($userId)->account;
            });
            $grid->recorder_id('记录人')->display(function($id) {
                return WxRecorder::find($id)->name;
            });
            $grid->column('grade', __('分值'));
            $grid->column('remark', __('备注'));
            $grid->is_add('加分？')->display(function ($effective) {
                return $effective ? '加分' : '减分';
            });
            $grid->column('created_at', __('创建时间'));
            $grid->column('updated_at', __('修改时间'));
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
//                $filter->like('username', '客户名称');
//                $filter->like('ip', 'IP地址');
                $filter->is('is_add', '加减分')->select(['0'=>'减分', '1'=>'加分']);
//                $filter->is('province', '省份')->select(Insurance::$provinces);

                $filter->where(function ($query) {
                    $query->whereHas('wx_user', function ($query) {
                        $query->where('user_id', '=', $this->input);
                    });
                }, '农户')->select(WxUser::all()->pluck('account', 'id')->toArray());
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
        return Admin::form(WxRecord::class, function (Form $form) {

            $form->display('id', 'ID');
            $user = WxUser::all()->pluck('account', 'id');
            $form->select('user_id', '农户')->options($user);
            $recorder = WxRecorder::all()->pluck('name', 'id');
            $form->select('recorder_id', '记录人')->options($recorder);
            $form->text('grade', '分值');
            $form->textarea('remark', '备注');
            $form->select('effective', '加分？')->options(['0'=>'减分', '1'=>'加分'])->default(1);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
