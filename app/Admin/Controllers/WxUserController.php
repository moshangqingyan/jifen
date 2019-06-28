<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Listen;
use App\Model\WxLabel;
use App\Model\WxUser;

use App\Model\WxUserLabel;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WxUserController extends Controller
{
    use ModelForm;

    public function code(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return false;
        }
        $res = QrCode::format('png')->size(200)->color(255,0,255)->encoding('UTF-8')->generate('http://jifen.zteamtech.com/index?number=68?id=' . $id, $id.'.png');
        if ($res) {
            return url($id . '.png');
        } else {
            return false;
        }
    }

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
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('用户-详情');
            $content->description('');

            $content->row($this->showForm()->view($id));
        });
    }

    /**
     * 用户信息详情页面
     *
     * @return Form
     */
    protected function showForm()
    {
        return Admin::form(WxUser::class, function (Form $form) {
            $form->tab('用户信息', function (Form $form) {
                $form->display('id', 'ID');
                $form->text('account', __('户主'));
                $form->number('population', __('人口数'))->default(3);
                $form->text('addr', __('家庭地址'));
                $form->mobile('phone', __('联系电话'));
                $form->text('openId', __('OpenId'));
                $form->text('longitude', __('经度'));
                $form->text('latitude', __('纬度'));
                $form->radio('sex')->options(['0' => '男', '1'=> '女'])->default($form->model()->sex);
                $form->display('created_at', '创建时间');
                $form->display('updated_at', '修改时间');
            })->tab('标签', function (Form $form) {
                $arr = request()->route()->parameters();
                $defaultLabel = WxUserLabel::where([['user_id', array_get($arr, 'wxuser')]])->get(['label_id'])->toArray();
                $default = [];
                if (is_array($defaultLabel)) {
                    foreach ($defaultLabel as $v) {
                        $default[] = $v['label_id'];
                    }
                }
                $form->multipleSelect('labels', '荣誉标签')->options(WxLabel::all()->pluck('name', 'id'))->default($default);
            });
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

            $content->body($this->createForm()->edit($id));
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

            $content->body($this->createForm());
        });
    }

    /**
     * 用户信息新增页面表单
     *
     * @return Form
     */
    protected function createForm()
    {
        return Admin::form(WxUser::class, function (Form $form) {
            $form->tab('用户信息', function (Form $form) {
                $form->text('account', __('户主'));
                $form->number('population', __('人口数'))->default(3);
                $form->text('addr', __('家庭地址'));
                $form->mobile('phone', __('联系电话'));
                $form->text('openId', __('OpenId'));
                $form->text('longitude', __('经度'));
                $form->text('latitude', __('纬度'));
                $form->radio('sex')->options(['0' => '男', '1'=> '女']);
            })->tab('标签', function (Form $form) {
                $options = WxLabel::all()->pluck('name', 'id');
                $form->multipleSelect('labels', '选择标签')->options($options);
            });
        });
    }

    public function store()
    {
        return $this->createForm()->store();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(WxUser::class, function (Grid $grid) {
//            $grid = new Grid(new Wxuser);

            $grid->column('id', __('Id'));
            $grid->column('account', __('户主'));
            $grid->column('population', __('人口数'));
            $grid->column('addr', __('家庭地址'));
            $grid->column('phone', __('联系电话'));
            $grid->column('openId', __('OpenId'));
            $grid->column('latitude', __('经度'));
            $grid->column('longitude', __('纬度'));

            $grid->labels('标签')->display(function ($roles) {

                $roles = array_map(function ($role) {
                    return "<span class='label label-success'>{$role['name']}</span>";
                }, $roles);
                return join('&nbsp;', $roles);
            });

            $grid->column('created_at', __('创建时间'));
            $grid->column('updated_at', __('修改时间'));
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('account', '户主');
                $filter->like('addr', '家庭地址');
            });

            $grid->actions(function ($actions) {

                // 添加操作
                $actions->append(new Listen($actions->getKey()));
            });

            return $grid;
        });
    }



    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return Content
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
//        $this->validate($request, [
//            'username' => 'required',
//            'login_id' => 'required',
//        ]);

        $model = WxUser::findOrFail($id);

        $data = $request->all();
        $model->setAttribute('account', $data['account']);
        $model->setAttribute('population', $data['population']);
        $model->setAttribute('addr', $data['addr']);
        $model->setAttribute('phone', $data['phone']);
        $model->setAttribute('openId', $data['openId']);
        $model->setAttribute('longitude', $data['longitude']);
        $model->setAttribute('latitude', $data['latitude']);
        $model->setAttribute('sex', $data['sex']);

        $model->save();

        $model->labels()->sync(array_filter($data['labels']));

        return $this->show($id);
    }

    public function destroy($id)
    {
// 删除用户表记录与
        if (WxUser::destroy($id)) {
            // 用户账号和标签的中间表记录
            WxUserLabel::where('user_id', '=', $id)->delete();
            return response()->json([
                'status' => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }
}
