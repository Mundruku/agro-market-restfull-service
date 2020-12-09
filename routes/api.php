<?php

use Illuminate\Http\Request;

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


//Admin route groups 

Route::prefix('admin')->group(function () {

   
/* User register and Login routes */

Route::post('/login', 'API\Auth\AdminAuthController@admin_login');



/**Private route group for the admininistrator  */


Route::middleware(['auth:api', 'admin:api'])->group(function(){

Route::post('password/update', 'API\Auth\AdminAuthController@admin_password_update');

Route::get('/logout', 'API\Auth\AdminAuthController@admin_logout');
});




});




//Route  group for the user


Route::prefix('user')->group(function () {

   
/* User Authentication routes */



Route::post('/register', 'API\Auth\AuthController@register');
Route::post('/login', 'API\Auth\AuthController@login');
Route::post('/forgot/password', 'API\Auth\ForgotPasswordController@forgot_password');
Route::post('/password/reset', 'API\Auth\ForgotPasswordController@reset_password');
Route::get('email/verify/{id}', 'API\Auth\VerificationApiController@verify')->name('verificationapi.verify');
Route::get('/details', 'API\Auth\AuthController@details');




//Public routes for the user 




/**Private routes for the user  */

Route::middleware('auth:api')->group(function(){

Route::get('email/resend', 'API\Auth\VerificationApiController@resend')->name('verificationapi.resend');

Route::post('password/update', 'API\Auth\AuthController@user_password_update');

Route::get('/logout', 'API\Auth\AuthController@logout');
});




});





/* Public routes */





