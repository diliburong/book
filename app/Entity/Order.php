<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table='order'; //绑定表名	
    protected $primarykey='id'; //绑定主键
}
