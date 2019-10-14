<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Patient;
use App\Emergency;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Storage;
use App\Events\EmergencyCreated;

class AuthController extends Controller 
{
 public $successStatus = 200;

 public function register(Request $request) {    
    $validator = Validator::make($request->all(), [ 
                 'name' => 'required',
                 'username' => 'required',
                 'password' => 'required',
                 'usertype' => 'required',  
                 'c_password' => 'required', 
       ]);   
    if ($validator->fails()) {          
          return response()->json(['error'=>$validator->errors()], 401);                        }    
    $input = $request->all();  
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input); 
    $success['token'] =  $user->createToken('AppName')->accessToken;
    return response()->json(['success'=>$success], $this->successStatus); 
   }
    
     
   public function login(){ 
      if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){ 
         $user = Auth::user(); 
         $success['token'] =  $user->createToken('AppName')-> accessToken; 
         $name=$user->name;

         return response()->json(['success' => $success,$user], $this-> successStatus); 
      } else{ 
         return response()->json(['error'=>'Unauthorised'], 401); 
         } 
   }
    
   public function getUser() {
    $user = Auth::user();
    return response()->json(['success' => $user], $this->successStatus); 
    }


    public function addpatient(Request $request) {  
      $validator = Validator::make($request->all(), [ 
                   'name' => 'required',
                   'age' => 'required',
         ]);   
      if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        }    
      $input = $request->all();  
      $patient = Patient::create($input); 
      return response()->json(['patient'=>$patient], $this->successStatus); 
     }

     public function getemergency(Request $request)
      { 
         $id=$request->patient_id;
         $emergency = \DB::table('emergency')->where('patient_id',$id)->orderBy('created_at', 'desc')->get();
         return response()->json(['success' => $emergency], $this->successStatus); 

      } 

      public function addemergency(Request $request)
      {
         $emergency = new Emergency;
         $emergency->patient_id =$request->patient_id;
         $emergency->button = $request->button;
         $emergency->sensor = $request->sensor;
         $emergency->voice = $request->voice;
         $emergency->confirmed = 0;
         $emergency->latitude = $request->lat;
         $emergency->longitude = $request->lon;
         $emergency->save();
      }

      public function getpatients() {
         $user = Auth::user();
         $allpatients=\DB::table('patient_assign')->where('user_id',$user->id)->get();
         $result = [];
          foreach($allpatients as $patient)
            {
               $patient_result= \DB::table('patients')->where('id',$patient->patient_id)->get()->first();
               array_push($result, $patient_result);
            }

              return response()->json(['patients'=>$result], $this->successStatus); 
         
         }

         public function history (Request $request)
         {        
            $id=$request->patient_id;
            $history = \DB::table('history')->where('patient_id',$id)->get();
            return response()->json(['success' => $history], $this->successStatus); 
         }

         public function getpatient(request $request)
         {
            $patient=\DB::table('patients')->where('id',$request->id)->get()->first();
            $comment=\DB::table('comments')->where('patient_id',$request->id)->orderBy('created_at', 'desc')->first();
            if($patient->room_id)
            $room_number=\DB::table('rooms')->where('id',$patient->room_id)->first();
            else
            $room_number=0;
            return response()->json(['success' => $patient,'comment'=>$comment,'room'=>$room_number], $this->successStatus); 
         }

         public function confirm(Request $request){
            $emergency_id = $request->id;
            $emergency = Emergency::where('id', $emergency_id)->first();
            $emergency->confirmed = 1;
            $emergency->save();
            return response()->json(['success' => "true"], $this->successStatus);
         }

         public function addcomment(Request $request){
            \DB::table('comments')->insert(
               ['patient_id' => $request->patient_id, 'user_id' => Auth::user()->id,'comment'=>$request->comment]
               
            );
            return response()->json(['success'=>"true"]);
                 
         }


}