<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'order';
    public function puser(){
        return  $this->belongsTo(Administrator::class,'user_id','id');
    }
    public function piduser(){
        return  $this->belongsTo(Administrator::class,'pid','id');
    }
}
