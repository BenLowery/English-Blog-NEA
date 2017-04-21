<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	*/
	protected $table = 'tokens';

	public function user() {
		return $this->belongsTo('App\Models\Users');
	}
}