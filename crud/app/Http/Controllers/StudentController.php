<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
    	$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
    	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
    	if($keyword != ""){
		$students = Student::with(['ShowDepartment' => function($q) use ($keyword){
            $q->where('name', 'like', '%'.$keyword.'%');
        }])->where('students.name', 'like', '%'.$keyword.'%')->orWhere('students.email', 'like', '%'.$keyword.'%')->orWhere('students.course', 'like', '%'.$keyword.'%')->orderBy('id','desc')->paginate($limit);
    	}else{
    		$students = Student::orderBy('id','desc')->paginate($limit);
    	}
    	$departments = Department::get();
    
    	if(isset($_GET['page'])){
    		return view('students.render_students', ['students' => $students])->render();
    	}else{
    		return view('students.index', ['students' => $students, 'departments'=> $departments]);
    	}
    }

    public function saveStudents(Request $request){
    	$validation = Validator::make($request->all(),[
    		'name' => 'required',
    		'department'=> 'required',
    		'email' => 'required|email|unique:students',
            'image' => 'required|mimes:jpg,jpeg,png,gif',
    		'course' => 'required',
			'dob' => 'required',
			'gender' => 'required',
    	]);
    	if($validation->fails()){
    		return array('status' => 'errors','errors' => $validation->errors());
    	}
    	$data = [
    		'name' => $request->input('name'),
    		'department_id' => $request->input('department'),
    		'name' => $request->input('name'),
    		'email' => $request->input('email'),
    		'course' => $request->input('course'),
    		'dob' => $request->input('dob'),
    		'gender' => $request->input('gender'),
    	];
        if(isset($request->image)){
            $filename = 'img-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('upload'), $filename);
            $filePath = 'upload/'.$filename;
            $data = array_merge($data, array('image'=>$filePath));
        }
    	DB::table('students')->insert($data);
    	return array('status' => 'success', 'message' => 'Student Saved Successfully');

    }

    public function editStudent($id){
    	$student = Student::where(['id' => $id])->first();
    	$departments = Department::get();
    	return view('students.edit_student', ['student' => $student, 'departments'=>$departments, 'id' => $id])->render();
    }

    public function updateStudent($id, Request $request){

    	//print_r($request->all()); die;
    	$validation = Validator::make($request->all(),[
    		'name' => 'required',
    		'department'=> 'required',
    		'email' => 'required',
    		'course' => 'required',
			'dob' => 'required',
			'gender' => 'required',
    	]);
    	if($validation->fails()){
    		return array('status' => 'errors','errors' => $validation->errors());
    	}
    	$data = [
    		'name' => $request->input('name'),
    		'department_id' => $request->input('department'),
    		'name' => $request->input('name'),
    		'email' => $request->input('email'),
    		'course' => $request->input('course'),
    		'dob' => $request->input('dob'),
    		'gender' => $request->input('gender'),
    	];

         if(isset($request->image)){
            $filename = 'img-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('upload'), $filename);
            $filePath = 'upload/'.$filename;
            $data = array_merge($data, array('image'=>$filePath));
        }

    	DB::table('students')->where(['id'=>$id])->update($data);
    	return array('status' => 'success', 'message' => 'Student Updated Successfully');
    }


    public function deleteStudent($id){
    	Student::where(['id' => $id])->delete();
    	return array('status' => 'success', 'message' => 'Student Deleted Successfully');
    }
}
