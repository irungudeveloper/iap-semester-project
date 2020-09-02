<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Assignment;


class AssignmentController extends Controller
{
    //
    public function index(){

    	$message = "You've Hit the controller";

    	return $message;

    }

    public function create(Request $request, $teacherid){


    	$assignmentData = $request->validate([

    			'assignment'=>'required',
    			'class_id'=>'required'

    	]);

    	$assignment=  new Assignment;

    	$assignment->description = $request->assignment;
    	$assignment->teacher_id = $teacherid;
    	$assignment->class_id = $request->class_id;

    	$assignment->save();

    	$response['message'] = "Assignment Created";
    	$response['code'] = "201";

    	return $response;

    }

    public function displayAll(){
    	$assignment = Assignment::paginate(10);

    	$assignment['message'] = "Records Fetched Successfully";
    	$assignment['code'] = "200";
    }

    public function displayTeacherAssignment($teacherid){

    	$assignment = Assignment::where('teacher_id',$teacherid)->paginate(10);

    	$assignment['message'] = "Records Fetched Successfully";
    	$assignment['code'] = "200";

    	return $assignment;

    }

    public function update($teacherid,$assignmentid,Request $request){

    	$assignment = Assignment::findOrFail($assignmentid);
    	$assignmentData = $request->validate([

    		'assignment'=>'required',
    		'class_id'=>'required'

    	]);

    	$assignment->description = $request->assignment;
    	$assignment->teacher_id = $teacherid;
    	$assignment->class_id = $request->class_id;

    	$assignment->save();
    	$assignment['message'] = "Assignment Updated";
    	$assignment['code'] = "200";

    	return $assignment;


    }

    public function delete($teacherid,$id)
    {
    	$assignment = Assignment::findOrFail($id);

    	$assignment->delete();

    	$response['message'] = "Assignment Deleted Succesfully";
    	// $response['ass-id'] = $id;
    	$response['code'] = "200";

    	return $response; 
    }
}
