<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $cast = [
        'handle_params' => 'array',
    ];
    //
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(TaskOrder::class, 'order_no', 'out_trade_no');
    }

    public function statusLabel() {
        return self::stateLabel($this->handle_state);
    }

    /**
     * @param $state
     * @return string
     */
    public static function stateLabel($state) {
        switch ($state) {
            case 'created':
            case 'resource_waiting':
                return '等待素材上传';
            case 'resource_uploaded':
                return '素材上传完成';
            default:
                return $state;
        }
    }
}
