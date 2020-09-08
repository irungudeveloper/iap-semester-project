<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\teacher;
use App\User;
use App\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;



class TeacherController extends Controller
{
    //
    use AuthenticatesUsers;

    public $successStatus = 200;

    public function __construct()
    {
    	$this->middleware('guest')->except('logout');
    }

    public function createTeacher(Request $request)
    {

        $validator = Validator::make($request->all(),[

                'tsc_number'=>'required',
                'f_name'=>'required',
                'l_name'=>'required',
                'telephone'=>'required',
                'address'=>'required',
                'date_of_employment'=>'required',
                'email'=>'email|required',
                'password'=>'required'

        ]);

        if ($validator->passes()) 
        {
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

    	return response()->json(['error','Please Fill Out All The Fields Required'],406);

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
    	$teacher = teacher::paginate(10);

        if (count($teacher)) 
        {
            return response()->json(['success'=>$teacher],200);    
        }

    	return response()->json(['error','No Records Available']);
    }

    public function viewSingle($id)
    {
    	$teacher = teacher::findOrFail($id);

        if (count($teacher)) 
        {
            return response()->json(['success'=>$teacher],200);    
        }

    	return response()->json(['error','Record Not Found']);
    }

    public function update($id,Request $request)
    {
    	$teacher = teacher::findOrFail($id);

        if (count($teacher)) 
        {
            $user = User::where('email',$request->email)->first();

            if (count($user)) 
            {

                $validator = Validator::make($request->all(),[

                    'tsc_number'=>'required',
                    'f_name'=>'required',
                    'l_name'=>'required',
                    'telephone'=>'required',
                    'address'=>'required',
                    'date_of_employment'=>'required',
                    'email'=>'email|required',
                    'password'=>'required'

                ]);

               if ($validator->passes()) 
               {
                     $hash = password_hash($request->password, PASSWORD_BCRYPT);
                     $teacherData['password'] = $hash;

                     $teacher->tsc_number = $request->tsc_number;
                     $teacher->f_name = $request->f_name;
                     $teacher->l_name = $request->l_name;
                     $teacher->telephone = $request->telephone;
                     $teacher->address = $request->address;
                     $teacher->date_of_employment = $request->date_of_employment;
                     $teacher->email = $request->email;
                     $teacher->password = $hash;

                     $user->name = $request->f_name;
                     $user->email = $request->email;
                     $user->password = $hash;

                     $teacher->save();
                     $user->save();

                     $teacher['token'] = $user->createToken('Teacher Update Token')->accessToken;

                    return response()->json(['success'=>$teacher], 200);
               }

            return response()->json(['error','Please Fil Out All The Fields Required']);
                
            }

            return response()->json(['error','User Not Found']);
                
        }

        return response()->json(['error','Teacher Record Not Found']);
    	
    }

    public function delete($id)
    {
    	$pickEmail;
    	$teacher = teacher::findOrFail($id);

    	foreach ($teacher as $data) 
    	{
    		$pickEmail = $data->email;
    	}

    	$user = User::where('email',$pickEmail)->get();

    	$teacher->delete();
    	$user->delete();

    	return response()->json(['success'=>'Record Deleted'],200);
    }

    public function studentsView($classid)
    {
   		$student = Student::where('class_id',$classid)->get()->paginate(10);

        if (count($student)) 
        {
           return response()->json(['success'=>$student],200);
        }

        return response()->json(['error','No Records Found']);
   		
    }

}
