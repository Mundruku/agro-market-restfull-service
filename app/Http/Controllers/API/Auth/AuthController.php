<?php

namespace App\Http\Controllers\API\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
 






   //registering user

    public function register(Request $request)
{
    /**Validate the data using validation rules
    */
    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required|regex:/[0-9]{10}/',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'user_type'=>'required',
    ]);
         
    /**Check the validation becomes fails or not
    */
    if ($validator->fails()) {
        /**Return error message
        */
        return response()->json([ 'error'=> $validator->errors() ]);
    }

    /**Store all values of the fields
    */
    $newuser = $request->all();

        /**Create an encrypted password using the hash
    */
    $newuser['password'] = Hash::make($newuser['password']);

    /**Insert a new user in the table
    */
    $user = User::create($newuser);

        /**Create an access token for the user
    */
    $success['token'] = $user->createToken('AgroMarket')->accessToken;

    //send an email verification to the user 


    $user->sendApiEmailVerificationNotification();


    /**Return success message with token value
    */
    return response()->json(['success'=>$success, 'verify'=>'email verification needed'], 200);
}



    //User login function 

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $data = $request->all();
        $userCount = User::where('email', $data['email']);
        $role_check=User::where('email', $data['email'])->first();

        if (!$userCount->count()) {
            return response(['error'=>'User email not found']);
        }

        //checking user role in the User Auth controller 

       

        //checking authentication match for user type User 


        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Password']);
        }
        


        //checking email verification status

        if($role_check->email_verified_at==NULL){
            return response(['error' => 'Please verify your']);
        } 


        
        //Generating access  token for the User
        $accessToken = auth()->user()->createToken('authToken')->accessToken;


        //Returning response for  the user 

        return response(['user' => auth()->user(),'user_type'=>'user', 'access_token' => $accessToken]);

    }



   //password update 

    public function user_password_update(Request $request){

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


    //User Logout funtion

    public function logout(Request $request)
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
