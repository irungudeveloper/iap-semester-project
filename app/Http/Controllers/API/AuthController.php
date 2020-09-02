<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
 
    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];
 
    if( auth()->attempt($credentials) )
    {
      $user = Auth::user();
  	  $success['token'] =  $user->createToken('Login Token')->accessToken;
      return response()->json(['success' => $success], 200);
    } 
    else 
    {
		return response()->json(['error'=>'Unauthorised'], 401);
    }
  }
    
  public function register(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
      'password_confirmation' => 'required|same:password',
    ]);
 
    if ($validator->fails())
    {

      return response()->json([ 'error'=> $validator->errors() ]);
    
    }

	$data = $request->all();
	$data['password'] = Hash::make($data['password']);
	$user = User::create($data);
	$success['token'] =  $user->createToken('Register Token')->accessToken;
	return response()->json(['success'=>$success], 200);
 
  }

  public function reach()
  {
  	
  	$message = "Authentication Working";

  	return response()->json(['success'=>$message],200);

  }

}
