<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskOrder extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'out_trade_no';
    //
    public function tasks() {
        return $this->hasMany('Task', 'order_no', 'out_trade_no');
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
}
