<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

      $validator = Validator::make($request->all(),[

          'class_name'=>'required',
          'capacity'=>'required'

      ]);

    	if ($validator->passes()) 
      {
        $class->class_name = $request->class_name;
        $class->capacity = $request->capacity;

        $class->save();

        $response['message'] = "Class Created Successfully";
        $response['code'] = "201";

        return $response;
      }


    return response()->json(['error','Please Fill Out All The Fields Required']);

    }

   	public function displayClasses()
   	{
   		$class = Classes::paginate(10);

      if (count($class)) 
      {
        $class['message'] = "Records Fetched Successfully";
        $class['code'] = "200";

        return $class;
      }

      return response()->json(['error','No Records Available']);

   		
   	}

   	public function edit($id)
   	{
   		$class = Classes::findOrFail($id);

      if (count($class)) 
      {
        $class['message'] = "Records Fetched Successfully";
        $class['code'] = "200";

        return $class;
      }

   		return response()->json(['error','No Records Available']);
   	}

   	public function update($id, Request $request)
   	{

   		$class = Classes::findOrFail($id);

      $validator = Validator::make($request->all(),[

            'class_name'=>'required',
            'capacity'=>'required'

      ]);

   	if ($validator->passes()) 
    {
      $class->class_name = $request->class_name;
      $class->capacity = $request->capacity;

      $class->save();

      $class['message'] = "Record Updated Successfully";
      $class['code'] = "200";

      return $class;
    }

   		return response()->json(['error','No Records Found']);

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
