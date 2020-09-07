<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use App\Assignment;
use App\Student;


class AssignmentController extends Controller
{
    //
    public function index(){

    	$message = "You've Hit the controller";

    	return $message;

    }

    public function create(Request $request, $teacherid){


    	// $assignmentData = $request->validate([

    	// 		'assignment'=>'required',
    	// 		'class_id'=>'required'

    	// ]);

    	$assignment =  new Assignment;
        $validator = Validator::make($request->all(),[
                'assignment'=>'required',
                'class_id'=>'required'
        ]);

        if ($validator->passes()) 
        {
            $assignment->description = $request->assignment;
            $assignment->teacher_id = $teacherid;
            $assignment->class_id = $request->class_id;

            $assignment->save();

            $response['message'] = "Assignment Created";
            $response['code'] = "201";

            return $response;
        }

        return response()->json(['error','Please FillOut All The Fields Required']);
    	

    }

    public function displayAll(){
    	$assignment = Assignment::paginate(10);

    	$assignment['message'] = "Records Fetched Successfully";
    	$assignment['code'] = "200";
    }

    public function displayTeacherAssignment($teacherid){

    	$assignment = Assignment::where('teacher_id',$teacherid)->paginate(10);

        if (count($assignment)) 
        {
            $assignment['message'] = "Records Fetched Successfully";
             $assignment['code'] = "200";

            return $assignment;
        }

        return response()->json(['error','No Records Available']);

    }

    public function displayStudentAssignment($studentid)
    {
        $student = Student::where('id',$studentid)->first();

        if (count($student)) 
        {
            $student_class_id = $student->class_id;
            $assignment = Assignment::where('class_id',$student_class_id)->paginate();
            
            if (count($assignment)) 
            {
                 return response()->json(['success'=>$assignment]);
            }

           return response()->json(['error','No Assignments Available']);
        }

        
         return response()->json(['error','Student Does Not Exist']);
       
    }

    public function update($teacherid,$assignmentid,Request $request){

    	$assignment = Assignment::findOrFail($assignmentid);
    	$assignmentData = $request->validate([

    		'assignment'=>'required',
    		'class_id'=>'required'

    	]);

        $validator = Validator::make($request->all(),[

            'assignment'=>'required',
            'class_id'=>'required'

        ]);

        if ($validator->passes()) 
        {
            
            $assignment->description = $request->assignment;
            $assignment->teacher_id = $teacherid;
            $assignment->class_id = $request->class_id;

            $assignment->save();
            $assignment['message'] = "Assignment Updated";
            $assignment['code'] = "200";

            return $assignment;

        }

    	return response()->json(['error','Assignment Not Found!! ']);


    }

    public function delete($teacherid,$id)
    {
    	$assignment = Assignment::findOrFail($id);

        if (count($assignment)) 
        {
            $assignment->delete();
            $response['message'] = "Assignment Deleted Succesfully";
            $response['code'] = "200";
            return $response;
        }

        return response()->json(['error','Record Not Found']);
    	 
    }
}
