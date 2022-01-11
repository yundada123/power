<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Assetsrecord extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'assetsrecord';
    public function user(){
      return  $this->belongsTo(Administrator::class,'uid');
    }
    public function Puser(){
        return  $this->belongsTo(User::class,'uid');
    }
    
}
