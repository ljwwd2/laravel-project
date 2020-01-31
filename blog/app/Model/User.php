<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //1.关联的数据表
    public $table = 'user';


//    2.主键

    public $primaryKey = 'user_id';

//    3.是否允许批量操作的字段


//    public $fillable = ['user_name','user_pass','email','phone'];//允许的

    public $guarded = []; //不允许的

//    4,是否维护crated_at 和 updated_at 字段
    public $timestamps = false;

}
