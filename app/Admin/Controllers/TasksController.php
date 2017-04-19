<?php

namespace App\Admin\Controllers;

use App\Models\Task;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use App\Admin\Extensions\ChangeState;
use Illuminate\Http\Request;
use App\Admin\Exporters\ExcelExporter;

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

    public function traceState(Request $request, Task $task) {
        if (!array_key_exists($request->input('state'), Task::$StateMap)) {
            return response()->json([
                'status' => false,
                'message' => '状态不正确'
            ]);
        }
        $task->handle_state = $request->input('state');
        $task->save();
        return response()->json([
            'status' => true,
            'message' => '状态更新成功'
        ]);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Task::class, function (Grid $grid) {
            $grid->model()->orderBy('updated_at', 'desc');
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
            $grid->column('storage_address', '上传地址');
            $grid->column('handle_params', '处理要求')->display(function($params) {
                $keys = [
                    'SizeList' => '尺寸',
                    'DimensionList' => '维数',
                    'FormatList' => '格式',
                    'PlatformList' => '平台',
                    'ExtraList' => '附加',
                ];
                $params = json_decode($params, true);
                $htmls = [];
                array_push($htmls, '<ul>');
                foreach($keys as $key => $label) {
                    $value = array_get($params, $key);
                    if (is_array($value)) {
                        array_push($htmls, "<li>$label: ".implode(", ", Task::ReadableParamList($value)).'</li>');
                    } else {
                        array_push($htmls, "<li>$label: ".$value.'</li>');
                    }
                }
                array_push($htmls, '</ul>');
                return implode("", $htmls);
            });
            $grid->column('handle_state', '处理状态')->display(function($handle_state) {
                return Task::stateLabel($handle_state);
            });
            $grid->column('order_no', '订单号');
            $grid->column('user_name', '用户');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');


            $grid->disableCreation();
            // $grid->disableActions();

            Admin::script($this->traceScript($grid->resource()));

            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->append(new ChangeState($actions->getKey(), $actions->getResource()));
            });

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
            $titleMaps = [
                'id' => '任务ID',
                'order_no' => '订单号',
                'user_id' => '用户ID',
                'user_name' => '用户名',
                'name' => '作业名',
                'handle_params' => '作业要求',
                'deliver_type' => '素材递交方式',
                'storage_address' => '云端地址',
                'created_at' => '创建日期',
            ];
            $grid->exporter(new ExcelExporter($titleMaps));
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

    protected function traceScript($resource) {
        return <<<SCRIPT
$('.dropdown.state-trace .dropdown-menu a').on('click', function() {
    $.ajax({
        method: 'post',
        url: '{$resource}/' + $(this).data('id') + '/!action/trace_state',
        data: {
            _token:LA.token,
            state: $(this).data('state')
        },
        success: function (data) {
            $.pjax.reload('#pjax-container');

            if (typeof data === 'object') {
                if (data.status) {
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            }
        }
    });
});
SCRIPT;
    }
}
