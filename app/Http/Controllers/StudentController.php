<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    use AuthenticatesUsers;

    public $successStatus = 200;

    public function createStudent(Request $request)
    {

        $validator = Validator::make($request->all(),[

            'f_name'=>'required',
            'l_name'=>'required',
            'date_of_birth'=>'required',
            'date_of_admission'=>'required',
            'email'=>'required',
            'password'=>'required',
            'class_id'=>'required'

        ]);

    	if ($validator->passes()) 
        {
           $hash = password_hash($request->password, PASSWORD_BCRYPT);

            $studentData['password'] = $hash;

            $student = Student::create($studentData);

            $user = new User;

            $user->name = $request->f_name;
            $user->email = $request->email;
            $user->password = $hash;

            $user->save();

            $student['token'] = $user->createToken('Student Registration Token')->accessToken;

            return response()->json(['success'=>$student], 200);
        }

            return response()->json(['error','Please Fill Out All The Fields Required']);
    	
    }

      public function login(Request $request)
     { 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
        { 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else
        { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function viewAll()
    {
    	$student = Student::paginate(10);

        if (count($student)) 
        {
           return response()->json(['success'=>$student],200);
        }

    	return response()->json(['error','No Records Found']);

    }

    public function edit($id)
    {
    	$student = Student::findOrFail($id);

        if (count($student)) 
        {
            return response()->json(['success'=>$student],200);
        }

    	return response()->json(['error','No Records Found']);
    }

    public function update($id,Request $request)
    {
    	$pickEmail;
    	$student = Student::findOrFail($id);

        if (count($student)) 
        {
            $pickEmail = $student->email;

            $user = User::where('email',$pickEmail)->first();

            if (count($user)) 
            {

               $validator = Validator::make($request->all(),[

                    'f_name'=>'required',
                    'l_name'=>'required',
                    'date_of_birth'=>'required',
                    'date_of_admission'=>'required',
                    'email'=>'required',
                    'password'=>'required',
                    'class_id'=>'required'

               ]); 

            if ($validator->passes()) 
            {
               $hash = password_hash($request->password, PASSWORD_BCRYPT);

                $studentData['password'] = $hash;

                $student->f_name = $request->f_name;
                $student->l_name = $request->l_name;
                $student->date_of_birth = $request->date_of_birth;
                $student->date_of_admission = $request->date_of_admission;
                $student->email = $request->email;
                $student->password = $hash;
                $student->class_id = $request->class_id;

                 $user->name = $request->f_name;
                 $user->email = $request->email;
                 $user->password = $hash;

                 $student->save();
                 $user->save();

                 $student['token'] = $user->createToken('Teacher Update Token')->accessToken;

                return response()->json(['success'=>$student], 200);
            }
                        
                return response()->json(['error','Please Fill Out All The Fields Reuired']);
            }

            return response()->json(['error','User Not Found']);
        }

        return response()->json(['Error','Student Record Not Found']);
    }

    public function delete($id)
    {
    	$pickEmail;
    	$student = Student::findOrFail($id);

    	$pickEmail = $student->email;
    	
    	$user = User::where('email',$pickEmail)->first();

    	
    	$user->delete();
    	$student->delete();

    	return response()->json(['success'=>'Record Deleted'],200);
    }

    public function studentView($classid)
    {
   		$student = Student::where('class_id',$classid)->paginate(10);

        if (count($student)) 
        {
            return response()->json(['success'=>$student],200);
        }

   		return response()->json(['error','Records Do Not Exist'],405);
    }
    

}
