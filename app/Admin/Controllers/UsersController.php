<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
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

            $content->header('用户管理');
            $content->description('');

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

            $content->header('修改用户信息');
            $content->description('');

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

            $content->header('创建用户');
            $content->description('');

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
        return Admin::grid(User::class, function (Grid $grid) {
            $grid->model()
                ->leftJoin('tasks', 'users.id', 'tasks.user_id')
                ->groupBy('users.id')
                ->select('users.*', DB::raw('count(tasks.id) as task_count'));

            $grid->column('username', '用户名');
            $grid->column('email', '邮箱');
            $grid->column('account_type', '账号类型')->display(function($account_type) {
                return $account_type == 'person' ? '个人' : '企业';
            });
            $grid->column('name', '公司名/姓名');
            $grid->column('phone_number', '联系电话');
            $grid->column('login_ip', '最近登录IP');
            $grid->column('login_at', '最近登录时间');
            $grid->column('created_at', '注册时间');
            $grid->column('activated_at', '激活时间');
            $grid->column('task_count', '任务数');

            // actions
            $grid->actions(function($actions) {
                $actions->disableDelete();
            });

            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableRowSelector();
            // filters
            $grid->filter(function($filter) {
               $filter->disableIdFilter();
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
        return Admin::form(User::class, function (Form $form) {
            $form->text('username', '用户名')->rules('required');
            $form->email('email', '邮箱')->rules('required|email');
            $form->select('account_type', '账号类型')->options(['person' => '个人', 'company' => '企业']);
            $form->text('name', '公司名/姓名')->rules('required');
            $form->text('phone_number', '联系电话')->rules('required');
            $form->text('country', '国家')->rules('required');
            $form->text('region', '地区')->rules('required');
            $form->password('password', '密码')->value('')->rules('min:6|confirmed');
            $form->password('password_confirmation', '重复密码')->value('');
            $form->ignore(['password_confirmation']);
//            $form->display('login_ip', '最近登录IP');
//            $form->display('login_at', '最近登录时间');
//            $form->display('created_at', '创建时间');
//            $form->display('updated_at', '更新时间');

            $form->saving(function(Form $form) {
                if ($form->password != "") {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }

    protected function detailForm() {
        return Admin::form(User::class, function (Form $form) {
            $form->text('username', '用户名')->rules('required');
            $form->email('email', '邮箱')->rules('required|email');
            $form->select('account_type', '账号类型')->options(['person' => '个人', 'company' => '企业']);
            $form->text('name', '公司名/姓名')->rules('required');
            $form->text('phone_number', '联系电话')->rules('required');
            $form->text('country', '国家')->rules('required');
            $form->text('region', '地区')->rules('required');
//            $form->display('login_ip', '最近登录IP');
//            $form->display('login_at', '最近登录时间');
//            $form->display('created_at', '创建时间');
//            $form->display('updated_at', '更新时间');
        });
    }
}
