<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';

	protected $fillable = [

			'f_name',
			'l_name',
			'date_of_birth',
			'date_of_admission',
			'email',
			'password',
			'class_id',
			
	];
}
