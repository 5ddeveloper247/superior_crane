<?php

use App\Http\Controllers\API\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
use App\Http\Controllers\API\RegistrationController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RigerTicketController;
use App\Http\Controllers\API\PayDutyController;
use App\Http\Controllers\API\TransportationTicketController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('sc/v1')->group(function () {

Route::post('register', [RegistrationController::class,'register'])->name('register');


Route::post('login', [LoginController::class,'login'])->name('login');
Route::post('validateemail', [LoginController::class,'validateemail'])->name('validateemail');
Route::post('verifyotp', [LoginController::class,'verifyotp'])->name('verifyotp');
Route::post('resetpassword', [LoginController::class,'resetpassword'])->name('resetpassword');


// Job routes 

Route::post('job/add', [JobController::class,'add_job'])->name('job/add');
Route::post('job/filtered_jobs', [JobController::class,'filtered_jobs'])->name('job/filtered_jobs');
Route::post('job/job_details', [JobController::class,'getJobDetails'])->name('job/job_details');
Route::post('job/changestatus', [JobController::class,'changestatus'])->name('job/changestatus');
Route::post('job/updatejob', [JobController::class,'updatejob'])->name('job/updatejob');

// Rigger Tickets routes 
Route::post('riggerticket/add', [RigerTicketController::class,'add_rigger_ticket'])->name('riggerticket/add');
Route::post('riggerticket/sendtomail', [RigerTicketController::class,'sendtomail'])->name('riggerticket/sendtomail');

// Pay Duty 
Route::post('payduty/add', [PayDutyController::class,'add_pay_duty'])->name('payduty/add');

// Transportation Tickets 
Route::post('transportationticket/add', [TransportationTicketController::class,'add_transportation_ticket'])->name('transportationticket/add');












});
