<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','API\AuthController@login');
Route::post('register','API\AuthController@register');


// Teacher Login & Registration //CRUD 
Route::post('teacher/register','TeacherController@createTeacher');
Route::post('teacher/login','TeacherController@login');
// Route::get('teacher/view/all','TeacherController@viewAll');
// Route::post('teacher/view/{id}','TeacherController@viewSingle');
// Route::post('teacher/update/{id}','TeacherController@update');
// Route::post('teacher/delete/id','TeacherController@delete');


// Student Login & Registration //CRUD
Route::post('student/register','StudentController@createStudent');
Route::post('student/login','StudentController@login');
// Route::get('student/view/all','StudentController@viewAll');
// Route::post('teacher/view/{id}','StudentController@viewSingle');
// Route::post('student/update/{id}','StudentController@update');
// Route::post('student/delete/id','StudentController@delete');


Route::middleware('auth:api')->group(
	function()
	{

		Route::get('reach','API\AuthController@reach');

		// Student CRUD Routes
		Route::get('student/view/all','StudentController@viewAll');
		Route::post('teacher/view/{id}','StudentController@viewSingle');
		Route::post('student/update/{id}','StudentController@update');
		Route::post('student/delete/id','StudentController@delete');

		//Teacher CRUD Routes
		Route::get('teacher/view/all','TeacherController@viewAll');
		Route::post('teacher/view/{id}','TeacherController@viewSingle');
		Route::post('teacher/update/{id}','TeacherController@update');
		Route::post('teacher/delete/{id}','TeacherController@delete');
		Route::post('teacher/{teacherid}/class/{id}/student/all','TeacherController@studentsView');

		// Class CRUD Routes
		Route::post('class/create','ClassesController@create');
		Route::get('class/view','ClassesController@displayClasses');
		Route::post('class/view/{id}','ClassesController@edit');
		Route::post('class/update/{id}','ClassesController@update');
		Route::post('class/delete/{id}','ClassesController@delete');

		//Teacher Assignment Routes 
		Route::post('teacher/{teacherid}/assignment/create','AssignmentController@create');
		Route::post('teacher/{teacherid}/assignment/view','AssignmentController@displayTeacherAssignment');
		Route::post('teacher/{teacherid}/assignment/update/{assignmentid}','AssignmentController@update');
		Route::post('teacher/{teacherid}/assignment/delete/{id}','AssignmentController@delete');

		// Student Assignment Routes
		Route::post('student/{studentid}/assignment/view','AssignmentController@displayStudentAssignment');
		Route::post('student/{studentid}/assignment/update/{assignmentid}','AssignmentController@updateStudentAssignment');



});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/