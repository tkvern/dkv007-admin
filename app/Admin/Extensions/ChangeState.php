<?php

/**
 * Created by PhpStorm.
 * User: liujun
 * Date: 2017/4/13
 * Time: 下午3:31
 */
namespace App\Admin\Extensions;
use Encore\Admin\Admin;

class ChangeState
{
    protected $id;

    public function __construct($id, $resource)
    {
        $this->id = $id;
        $this->resource = $resource;
    }

    protected function render() {
        return <<<HTML
<div class="dropdown state-trace" id="dropdown-{$this->id}">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    状态跟踪
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdown{{$this->id}}">
    <li><a href="#" data-state="20203" data-id="{$this->id}">拼接处理中</a></li>
    <li><a href="#" data-state="20204" data-id="{$this->id}">后期处理中</a></li>
    <li><a href="#" data-state="20205" data-id="{$this->id}">成品生成中</a></li>
    <li><a href="#" data-state="20206" data-id="{$this->id}">成品已发出待验证</a></li>
  </ul>
</div>
HTML;

    }

    public function __toString()
    {
        return $this->render();
    }
}