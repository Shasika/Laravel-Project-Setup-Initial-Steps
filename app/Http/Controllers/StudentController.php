<?php

namespace App\Http\Controllers;

//use App\Models\Student;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function store(Request $request){
        //dd(1);
        $student = new Student([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);

        $student->save();
        return response()->json($student,200);
    }

    public function getAllStudents(){
        $students = Student::all();
        return response()->json($students,200);
    }
    public function deleteStudent($id){
        //dd($id);
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 200);
    }
    public function updateStudent(Request $request,$id){
        //dd($request);
        $Bank=DB::table('students')
            ->where("id",$id)
            ->update(array("name"=>$request['name'] , "email" => $request['email']
            ));

        return response()->json($Bank, 200);
    }
}
