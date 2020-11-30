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

   
/* User register and Login routes */

Route::post('/register', 'API\Auth\AuthController@register');
Route::post('/login', 'API\Auth\AuthController@login');
Route::post('/forgot/password', 'Api\AuthController@ForgotPasswordController');


//Public routes for the user 




/**Private routes for the user  */

Route::middleware('auth:api')->group(function(){

Route::post('password/update', 'API\Auth\AuthController@user_password_update');

Route::get('/logout', 'API\Auth\AuthController@logout');
});




});





/* Public routes */





