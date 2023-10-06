<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //let's create a function here
    public function index(){
        //let's get all info from the table by using the following 
     $students = Student::all();
     if($students->count()>0){
      return response()->json([
        "status"=>200,
        "students"=>$students
      ]);
     }
     else{
        return response()->json([
            "status"=>401,
            "message"=>"No Student Records Found"
        ]);
     }

    }
    // let's create a new function here
   public function store(Request $request){
    //let's validate all requests
    $validator = Validator::make($request->all(), [
        'name'=>'required|string|max:191',
        'course'=>'required|string|max:191',
        'email'=>'required|email|max:191',
        'phone'=>'required|digits:10'    
    ]);
   //let's check if the validation fails
   if($validator->fails()){
      return response()-> json([
        'status'=>422,
        'errors'=>$validator->messages()
      ]);
   }
   else{
    $student = Student::create(
        [
            'name'=>$request->name,
            'course'=>$request->course,
            'email'=>$request->email,
            'phone'=>$request->phone,

        ]
    );
    if($student){
        return response()->json([ 
            'status'=>200,
            'message'=> 'Student Record Successfully Added'
        ]);
    }
    else{
        return response()->json(
           [
            'status' => 500,
            'message'=>'Student Record Not Saved'
           ]
        );
    }
   }

   }
   //let's create a get data function
//    use the find function
   public function fetchData($id){
    $student = Student::find($id);
    if($student){
      return response()->json([
        'status'=>200,
        'student '=>$student
      ]);
    }
    else{
        return response()->json([
            'response_code'=>"404",
            'message'=>"No Such Record Found"
        ]);        
    }
   }
   //edit
 public function edit($id){
    $student = Student::find($id);
    if($student){
        return response()->json([
          'status'=>200,
          'student '=>$student
        ]);
      }
      else{
          return response()->json([
              'response_code'=>"404",
              'message'=>"No Such Record Found"
          ]);        
      }
 }
 public function update(Request $request, int $id){
    $validator = Validator::make($request->all(), [
        'name'=>'required|string|max:191',
        'course'=>'required|string|max:191',
        'email'=>'required|email|max:191',
        'phone'=>'required|digits:10'    
    ]);
    if($validator->fails()){
        return response()->json([
            'status'=>422,
            'errors'=>$validator->messages()
        ]);
    }
    else{
      $student=Student::find($id);
      //if the id is found go ahead to update
      if($student){
        $student->update(
          [
         'name'=>$request->name,  
          'course'=>$request->course,
          'email'=>$request->email,
          'phone'=>$request->phone
          ]
        );
        return response()->json([ 
            'status'=>200,
            'message'=> 'Student Record Updated Successfully'
        ]);
      }
      else{
        return response()->json(
           [
            'status' => 404,
            'message'=>'Student Record Not Found'
           ]
        );
    }
    }
 }
 //creating a delete api
 public function destroy($id){
  $student = Student::find($id);
  if($student){
     $student->delete();
     return response()->json([
        'status'=>200,
        'message'=>'Record Deleted',
     ]);
  }
  else{
    return response()->json([
        'status'=>404,
        'message'=>'No Such Student Found'
    ]);
  }

 }
}
