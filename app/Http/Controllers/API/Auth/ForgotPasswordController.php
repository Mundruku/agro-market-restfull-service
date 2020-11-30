<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    //


    public function forgot(){

    	$credential=request()->validate(['email'=>'required|email']);

    	/**Check the validation becomes fails or not
    	*/
    	if ($credential->fails()) {
    	    /**Return error message
    	    */
    	    return response()->json([ 'error'=> $validator->errors() ]);
    	}

    	$email=Password::sendResetLink($credential);


    	if ($email) {
    		return response(['success'=>'password reset linked sent']);
    	}


    }




}
