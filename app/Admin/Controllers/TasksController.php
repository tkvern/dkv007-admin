<?php

namespace App\Admin\Controllers;

use App\Models\Task;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TasksController extends Controller
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

            $content->header('VR作业列表');
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
        return Admin::grid(Task::class, function (Grid $grid) {

            $grid->id('ID');
            $grid->column('name', '名称');
            $grid->column('deliver_type', '素材递交方式')->display(function($deliver_type) {
                if ($deliver_type == 'network') {
                    return '网盘';
                } else if ($deliver_type == 'express') {
                    return '快递';
                } else {
                    return '';
                }
            });
            $grid->column('handle_params', '处理要求')->display(function($params) {
                return $params;
            });
            $grid->column('handle_state', '处理状态')->display(function($handle_state) {
                return Task::stateLabel($handle_state);
            });
            $grid->column('order_no', '订单号');
            $grid->column('user_name', '用户');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');


            $grid->disableCreation();
            $grid->disableActions();
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->disableRowSelector();
            $grid->filter(function($filter) {
                $filter->disableIdFilter();
                $filter->is('order_no', '订单号');
                $filter->between('created_at', '创建时间')->datetime();
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
        return Admin::form(Task::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
