<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    //
     protected $table = 'exams';

	protected $fillable = [

			'maths',
			'english',
			'kiswahili',
			'science',
			'socialstudies',
			'cre',
			'total',
			'student_id',
			'exam_id',
			
	];
}
