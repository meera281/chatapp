<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Mail\testEmail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function() {
    if(session()->has('role'))
    {
        session()->pull('role');
    }
    return redirect('login');
});

// Route::view('/testchat','testchat');


Route::group(['middleware'=> ['checkLogin']], 
function() {
    
    // Route::view('/login','login');
    Route::get('/login', function () {
        App::setlocale(session('language'));
        return view('login');
    });
    Route::post('/selectlanguage',[userController::class,'selectLanguage']);
    Route::post('getdata',[userController::class,'getData']);
    Route::view('/forgetpassword','forgetpassword');                            
    Route::post('updatedata',[userController::class,'updateData']);            // forget pw for login where we enter email
    Route::post('checkotp',[userController::class,'checkOtp']);                // enter otp after entering email in forget pw
    Route::post('setpassword',[userController::class,'setPassword']);          //enter pw and confirm pw
});


Route::group(['middleware'=> ['checkAgent']], 
function() {
    Route::view('/agent','agent');
    Route::get('/showagent',[userController::class,'showAgents']);
    Route::view('/resetpassword','resetpassword');
    Route::post('resetpassword',[userController::class,'resetPassword']);
    Route::get('/showchatdata',function(){
        return view('agent');
    });
    // Route::post('/searchagent',[userController::class,'searchAgent']);
    Route::get('/getchatdata/{id}',[userController::class,'getChatdata']);  // API 
    Route::post('/submitchatdata',[userController::class,'submitChatdata']);
    Route::post('/deletechat',[userController::class,'deleteChat']);
    Route::post('/backupchat',[userController::class,'backupChat']);
    Route::post('/restorechat',[userController::class,'restoreChat']);
});



Route::post('/getagentfromadmin', [userController::class,'getagentfromadmin']);


Route::group(['middleware'=> ['checkAdmin']], 
function() {
    Route::view('/admin','admin');
    Route::get('/admin',[userController::class,'showList']);            
    Route::get('/admin/{search}',[userController::class,'showList']);
    Route::view('/addagents','addagents');
    Route::post('addagent',[userController::class,'addAgent']);
    Route::view('/edit/{id}/{name}','editagent');
    Route::post('editagent',[userController::class,'editAgent']);
    Route::get('/deleteagent/{id}',[userController::class,'deleteAgent']);
});

