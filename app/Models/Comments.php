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

	public function post() {
		return $this->belongsTo('App\Models\Posts');
	}
}
