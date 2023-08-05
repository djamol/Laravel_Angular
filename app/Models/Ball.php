<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Log;

class Ball extends Model
{
    use SoftDeletes;
    protected $table = 'balls';

	/**
	 * [$rules rule list for add agent]
	 * @var [array]
	 */
	public static $rules = [
		'name' => 'required|max:45',
		'volume' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
	];
	public static $updateRule = [
		'name' => 'required|max:45',
		'volume' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
	];
	protected $dates = ['deleted_at'];

}
