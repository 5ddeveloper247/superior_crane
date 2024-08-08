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
Route::get('userslist', [RegistrationController::class,'getAllUsersList'])->name('userslist');

Route::post('login', [LoginController::class,'login'])->name('login');
Route::post('validateemail', [LoginController::class,'validateemail'])->name('validateemail');
Route::post('verifyotp', [LoginController::class,'verifyotp'])->name('verifyotp');
Route::post('resetpassword', [LoginController::class,'resetpassword'])->name('resetpassword');


// Job routes 

Route::post('job/add', [JobController::class,'add_job'])->name('job/add');
Route::post('job/filter_jobs', [JobController::class,'filter_jobs'])->name('job/filter_jobs');
Route::post('job/advance_filter_jobs', [JobController::class,'advance_filter_jobs'])->name('job/advance_filter_jobs');
Route::post('job/job_details', [JobController::class,'getJobDetails'])->name('job/job_details');
Route::post('job/changestatus', [JobController::class,'changestatus'])->name('job/changestatus');
Route::post('job/updatejob', [JobController::class,'updatejob'])->name('job/updatejob');
Route::post('job/getAssignedJobs', [JobController::class,'getAssignedJobs'])->name('job/getAssignedJobs');

// Rigger Tickets routes 
Route::post('riggerticket/add', [RigerTicketController::class,'add_rigger_ticket'])->name('riggerticket/add');
Route::post('riggerticket/update', [RigerTicketController::class,'update_rigger_ticket'])->name('riggerticket/update');
Route::post('riggerticket/ticket_list', [RigerTicketController::class,'getTicketList'])->name('riggerticket/ticket_list');
Route::post('riggerticket/ticket_detail', [RigerTicketController::class,'getTicketDetail'])->name('riggerticket/ticket_detail');
Route::post('riggerticket/sendtomail', [RigerTicketController::class,'sendtomail'])->name('riggerticket/sendtomail');

// Pay Duty 
Route::post('payduty/add', [PayDutyController::class,'add_pay_duty'])->name('payduty/add');
Route::post('payduty/update', [PayDutyController::class,'update_pay_duty'])->name('payduty/update');
Route::post('payduty/pay_duty_list', [PayDutyController::class,'getPayDutyList'])->name('payduty/pay_duty_list');
Route::post('payduty/pay_duty_detail', [PayDutyController::class,'getPayDutyDetail'])->name('payduty/pay_duty_detail');

// Transportation Tickets 
Route::post('transportationticket/add', [TransportationTicketController::class,'add_transportation_ticket'])->name('transportationticket/add');
Route::post('transportationticket/update', [TransportationTicketController::class,'update_transportation_ticket'])->name('transportationticket/update');
Route::post('transportationticket/ticket_list', [TransportationTicketController::class,'getTicketList'])->name('transportationticket/ticket_list');
Route::post('transportationticket/ticket_detail', [TransportationTicketController::class,'getTicketDetail'])->name('transportationticket/ticket_detail');












});
