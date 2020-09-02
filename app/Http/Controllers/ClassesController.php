<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;

class ClassesController extends Controller
{
    //

    public function index()
    {
    	$message = "Classes Controller";

    	return $message;
    }

    public function create(Request $request)
    {
    	$class = new Classes;

    	$classdata = $request->validate([

    		'class_name'=>'required',
    		'capacity'=>'required'

    	]);


    	$class->class_name = $request->class_name;
    	$class->capacity = $request->capacity;

    	$class->save();

    	$response['message'] = "Class Created Successfully";
    	$response['code'] = "201";

    	return $response;

    }

   	public function displayClasses()
   	{
   		$class = Classes::paginate(10);

   		$class['message'] = "Records Fetched Successfully";
   		$class['code'] = "200";

   		return $class;
   	}

   	public function edit($id)
   	{
   		$class = Classes::findOrFail($id);

   		$class['message'] = "Records Fetched Successfully";
   		$class['code'] = "200";

   		return $class;
   	}

   	public function update($id, Request $request)
   	{

   		$class = Classes::findOrFail($id);

   		$classdata = $request->validate([

   			'class_name'=>'required',
   			'capacity'=>'required'

   		]);

   		$class->class_name = $request->class_name;
   		$class->capacity = $request->capacity;

   		$class->save();

   		$class['message'] = "Record Updated Successfully";
   		$class['code'] = "200";

   		return $class;

   	}

   	public function delete($id)
   	{
   		$class = Classes::findOrFail($id);

   		$class->delete();

   		$response['message'] = "Class Deleted Succesfully";
    	// $response['ass-id'] = $id;
    	$response['code'] = "200";

    	return $response; 
   	}

}
