<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class teacher extends Authenticatable
{
    //
    use Notifiable,HasApiTokens;

    
	protected $table = 'teachers';

	protected $fillable = [

			'tsc_number',
			'f_name',
			'l_name',
			'telephone',
			'address',
			'date_of_employment',
			'email',
			'password',

	];
}
