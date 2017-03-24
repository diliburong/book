<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $table='order_item'; //绑定表名	
    protected $primarykey='id'; //绑定主键


    public $timestamps=false;
}
