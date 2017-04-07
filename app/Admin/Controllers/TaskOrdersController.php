<?php

namespace App\Admin\Controllers;

use App\Models\Task;
use App\Models\TaskOrder;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Table;

class TaskOrdersController extends Controller
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

            $content->header('订单列表');
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
     * Show interface
     *
     * return
     */
    public function show($id) {
        return Admin::content(function (Content $content) use ($id) {
            $order = TaskOrder::findOrFail($id);
            $tasks = $order->tasks;
            $content->header('订单详情');
            $content->description('');
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 'Goodwin-Watsica', '1997-08-13 13:59:21', 'open'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 'Murphy, Koepp and Morar', '1988-07-19 03:19:08', 'blocked'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 'Kihn LLC', '1978-06-19 11:12:57', 'blocked'],
                [4, 'xet@yahoo.com', 'William Koss', 'Becker-Raynor', '1988-09-07 23:57:45', 'open'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 'Braun Ltd', '2013-10-16 10:00:01', 'open'],
            ];
            $content->row(new Table([], $tasks->pluck('name', 'deliver_type', 'handle_state', 'handle_params')->all()));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(TaskOrder::class, function (Grid $grid) {

            $grid->column('out_trade_no', '订单号');
            $grid->column('user_name', '用户');
            $grid->column('state', '状态');
            $grid->column('pay_state', '支付状态');
            $grid->column('real_price', '订单价格')->display(function($real_price) {
                return round($real_price/100, 2);
            });
            $grid->created_at('创建日期');
            $grid->updated_at('更新时间');

            // actions
            $grid->actions(function($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $key = $actions->getKey();
                $actions->append('<a title="订单详情" href="'. "task_orders/$key" .'"><i class="fa fa-list-alt"></i></a>');
            });

            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableRowSelector();
            // filters
            $grid->filter(function($filter) {
                $filter->disableIdFilter();
                $filter->is('pay_state', '支付状态')->select(TaskOrder::$payStateMap);
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
        return Admin::form(TaskOrder::class, function (Form $form) {

            $form->display('out_trade_no', '订单号');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
