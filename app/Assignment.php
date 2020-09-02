<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //

	protected $table = 'assignment';

	protected $fillable = [

		'description',
		'teacher_id',
		'class_id',

	];

}
