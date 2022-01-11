<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Phoneorder extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'phoneorders';
    public function puser(){
        return  $this->belongsTo(Administrator::class,'uid','id');
    }
    public function piduser(){
        return  $this->belongsTo(Administrator::class,'pid','id');
    }
}
