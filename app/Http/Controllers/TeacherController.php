<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\teacher;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class TeacherController extends Controller
{
    //
    use AuthenticatesUsers;

    public $successStatus = 200;

    public function __construct()
    {
    	$this->middleware('guest')->except('logout');
    }

    public function createTeacher(Request $request){

    	 $teacherData = $request->validate([

                'tsc_number'=>'required',
                'f_name'=>'required',
                'l_name'=>'required',
                'telephone'=>'required',
                'address'=>'required',
                'date_of_employment'=>'required',
                'email'=>'email|required',
                'password'=>'required'

        ]);

    	 $hash = password_hash($request->password, PASSWORD_BCRYPT);

    	 $teacherData['password'] = $hash;

        $teacher = teacher::create($teacherData);

        $user = new User;

        $user->name = $request->f_name;
        $user->email = $request->email;
        $user->password = $hash;

        $user->save();

        $teacher['token'] = $user->createToken('Teacher Rgistration Token')->accessToken;

        return response()->json(['success'=>$teacher], 200);
        

    }

     public function login(Request $request)
     { 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }


}
