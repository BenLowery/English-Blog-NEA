<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
 	/**
	 * The database table used by the model.
	 *
	 * @var string
	*/
	protected $table = 'comment';
	// Since these tables are connected create a function and explain relationship
	public function post() {
		return $this->belongsTo('App\Models\Posts');
	}
}
