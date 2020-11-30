<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    


     //Admin login function 

     public function admin_login(Request $request)
     {
         $loginData = $request->validate([
             'email' => 'required|email',
             'password' => 'required'
         ]);
         
         $data = $request->all();
         $userCount = User::where('email', $data['email']);

         if (!$userCount->count()) {
             return response(['error'=>'User email not found']);
         }

         if (!auth()->attempt($loginData)) {
             return response(['message' => 'Invalid Password']);
         }

         $accessToken = auth()->user()->createToken('authToken')->accessToken;

         return response(['user' => auth()->user(), 'access_token' => $accessToken]);

     }



    //Admin password update 

     public function admin_password_update(Request $request){
         //get requests

         $request_data = $request->All();

         // validate the new password

        
         $validator = Validator::make($request->all(), [
             'password' => 'required|confirmed|min:6'
         ]);


         /**Check the validation becomes fails or not
         */
         if ($validator->fails()) {
             /**Return error message
             */
             return response()->json([ 'error'=> $validator->errors() ]);
         }

         $user_id = Auth::User()->id; 

         $obj_user = User::find($user_id);
         $obj_user->password = Hash::make($request_data['password']);
         $obj_user->save(); 
         return response(['message'=>'you have Successfully changed your password']);
              



     }


     //Admin Logout funtion

     public function admin_logout(Request $request)
     {
         if (Auth::check()) {
               Auth::user()->AauthAcessToken()->delete();
            }

         $request->user()->token()->revoke();
         return response()->json([
             'message' => 'Successfully logged out'
         ]);
     }
}
