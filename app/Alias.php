<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
	protected $table = "alias";

	protected $guarded = ['id'];

	public function file()
    {
        return $this->belongsTo('App\File', 'idFile');
    }
}
