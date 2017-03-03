<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table='product'; //绑定表名	
    protected $primarykey='id'; //绑定主键
}
