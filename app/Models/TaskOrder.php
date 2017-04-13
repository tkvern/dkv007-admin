<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskOrder extends Model
{
    // 支付状态
    const PAY_PENDING = '20101';
    const PAY_SUCCESS = '20102';
    const PAY_FREE = '20103';

    // 订单状态
    const Ord_HANDING = '20301';
    const Ord_REFUNDING = '20302';
    const Ord_COMPLETE = '20303';

    public static $PayStateMap = [
        self::PAY_FREE => '免费',
        self::PAY_PENDING => '等待支付',
        self::PAY_SUCCESS => '支付完成',
    ];

    public static $StateMap = [
        self::Ord_HANDING => '进行中',
        self::Ord_REFUNDING => '退款中',
        self::Ord_COMPLETE => '已完成',
    ];

    public $incrementing = false;
    protected $primaryKey = 'out_trade_no';


    // relations
    public function tasks() {
        return $this->hasMany(Task::class, 'order_no', 'out_trade_no');
    }

    // relation
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
         return isset(self::$PayStateMap[$payState]) ? self::$PayStateMap[$payState] : '未知';
    }

    public static function stateLabel($state) {

        return isset(self::$StateMap[$state]) ? self::$StateMap[$state] : '未知';
    }
}
