<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskOrder extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'out_trade_no';

    public static $payStateMap = [
        'pay_free' => '免费',
        'pay_waiting' => '等待支付',
        'pay_success' => '支付完成',
        'pay_cancel' => '取消支付'
    ];
    //
    public function tasks() {
        return $this->hasMany(Task::class, 'order_no', 'out_trade_no');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function getOrderNO() {
        $choiceOne = chr(rand(65, 90));
        $choiceTwo = chr(rand(65, 90));
        $choiceThree = rand(0, 9);
        $choiceFour = rand(0, 9);
        return $choiceOne.$choiceTwo.date('ymdHis').$choiceThree.$choiceFour;
    }

    public static function payStateLabel($payState) {
         return isset(self::$payStateMap[$payState]) ? self::$payStateMap[$payState] : '未知';
    }
}
