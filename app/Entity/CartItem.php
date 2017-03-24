<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    protected $table='cart_item'; //绑定表名	
    protected $primarykey='id'; //绑定主键
}
