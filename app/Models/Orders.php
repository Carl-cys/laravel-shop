<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Orders extends Model
{
    //
    protected $table = 'orders';

    use SoftDeletes;

    protected $dates = ['delete_at'];

    public function users()
    {
        return $this->belongsTo('App\Models\UserRegister','user_id');
    }
    public function usersname()
    {
        return $this->belongsTo('App\Models\UserLogin','user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrdersDetails','order_id','id');

    }

    public function orderSnDetails()
    {
        return $this->hasMany('App\Models\OrdersDetails','order_sn','sn');

    }

    public function orderDeliveryDoc()
    {
        return $this->hasMany('App\Models\DeliveryDoc','order_id','id');

    }


}
