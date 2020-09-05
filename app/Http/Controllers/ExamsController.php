<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use App\Exams;

class ExamsController extends Controller
{
    //

	public function createExam(Request $request,$examid,$studentid)
	{
		$exams = new Exams;

		$validator = Validator::make($request->all(), [
            'maths' => 'required',
            'english'=>'required',
            'kiswahili'=>'required',
            'science'=>'required',
            'socialstudies'=>'required',
            'cre'=>'required'
        ]);

		if ($validator->passes()) 
		{
			$exams->maths = $request->maths;
			$exams->english = $request->english;
			$exams->kiswahili = $request->kiswahili;
			$exams->science = $request->science;
			$exams->socialstudies = $request->socialstudies;
			$exams->cre = $request->cre;
			$exams->total = ($request->maths*2)+$request->english+($request->science*2)+($request->socialstudies/60)+( $request->cre/30);
			$exams->student_id = $studentid;
			$exams->exam_id = $examid;

			$exams->save();
			$exams['student_id'] = $studentid;
			$exams['exam_id'] = $examid;

			return response()->json(['success'=>$exams]); 
		}
        
		return response()->json(['failed'=>'Please Fill Out All The Fields Required']);	

	}

	public function updateExam(Request $request,$examid,$studentid)
	{
		$exams = Exams::where([
		    ['student_id', '=', $studentid],
		    ['exam_id', '=', $examid],
		])->first();

		$validator = Validator::make($request->all(), [
            'maths' => 'required',
            'english'=>'required',
            'kiswahili'=>'required',
            'science'=>'required',
            'socialstudies'=>'required',
            'cre'=>'required'
        ]);

		if ($validator->passes()) 
		{
			$exams->maths = $request->maths;
			$exams->english = $request->english;
			$exams->kiswahili = $request->kiswahili;
			$exams->science = $request->science;
			$exams->socialstudies = $request->socialstudies;
			$exams->cre = $request->cre;
			$exams->total = ($request->maths*2)+$request->english+($request->science*2)+($request->socialstudies/60)+( $request->cre/30);
			$exams->student_id = $studentid;
			$exams->exam_id = $examid;

			$exams->save();
			$exams['student_id'] = $studentid;
			$exams['exam_id'] = $examid;


			return response()->json(['success'=>$exams]); 
		}

      		return response()->json(['failed'=>'Please Fill Out All The Fields Required']);	

	}

	public function viewStudentExam($studentid)
	{
		$exams = Exams::where('student_id',$studentid)->paginate();

		return response()->json(['success',$exams]);
	}

	public function deleteStudentExam($examid,$studentid)
	{
		$exams = Exams::where([
				['student_id',$studentid],
				['exam_id',$examid],
		])->first();

		$exams->delete();

		return response()->json(['success','Record Successfully Deleted']);
	}

}
