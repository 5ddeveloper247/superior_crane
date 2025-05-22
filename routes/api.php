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
Route::post('delete_user', [RegistrationController::class,'delete_user'])->name('delete_user');

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
Route::post('job/addJobImages', [JobController::class,'addJobImages'])->name('job/addJobImages');
Route::post('job/deleteJobImage', [JobController::class,'deleteJobImage'])->name('job/deleteJobImage');
Route::post('job/viewTicketPdf', [JobController::class,'viewTicketPdf'])->name('job/viewTicketPdf');

// Rigger Tickets routes 
Route::post('riggerticket/add', [RigerTicketController::class,'add_rigger_ticket'])->name('riggerticket/add');
Route::post('riggerticket/update', [RigerTicketController::class,'update_rigger_ticket'])->name('riggerticket/update');
Route::post('riggerticket/ticket_list', [RigerTicketController::class,'getTicketList'])->name('riggerticket/ticket_list');
Route::post('riggerticket/ticket_detail', [RigerTicketController::class,'getTicketDetail'])->name('riggerticket/ticket_detail');
Route::post('riggerticket/sendtomail', [RigerTicketController::class,'sendtomail'])->name('riggerticket/sendtomail');
Route::post('riggerticket/addTicketImages', [RigerTicketController::class,'addTicketImages'])->name('riggerticket/addTicketImages');
Route::post('riggerticket/deleteTicketImage', [RigerTicketController::class,'deleteTicketImage'])->name('riggerticket/deleteTicketImage');
Route::post('riggerticket/getTicketsForPayduty', [RigerTicketController::class,'getTicketsForPayduty'])->name('riggerticket/getTicketsForPayduty');

// Pay Duty 
Route::post('payduty/add', [PayDutyController::class,'add_pay_duty'])->name('payduty/add');
Route::post('payduty/update', [PayDutyController::class,'update_pay_duty'])->name('payduty/update');
Route::post('payduty/pay_duty_list', [PayDutyController::class,'getPayDutyList'])->name('payduty/pay_duty_list');
Route::post('payduty/pay_duty_detail', [PayDutyController::class,'getPayDutyDetail'])->name('payduty/pay_duty_detail');
Route::post('payduty/addPayDutyImages', [PayDutyController::class,'addPayDutyImages'])->name('payduty/addPayDutyImages');
Route::post('payduty/deletePayDutyImage', [PayDutyController::class,'deletePayDutyImage'])->name('payduty/deletePayDutyImage');

// Transportation Tickets 
Route::post('transportationticket/add', [TransportationTicketController::class,'add_transportation_ticket'])->name('transportationticket/add');
Route::post('transportationticket/update', [TransportationTicketController::class,'update_transportation_ticket'])->name('transportationticket/update');
Route::post('transportationticket/ticket_list', [TransportationTicketController::class,'getTicketList'])->name('transportationticket/ticket_list');
Route::post('transportationticket/ticket_detail', [TransportationTicketController::class,'getTicketDetail'])->name('transportationticket/ticket_detail');
Route::post('transportationticket/addTicketImages', [TransportationTicketController::class,'addTicketImages'])->name('transportationticket/addTicketImages');
Route::post('transportationticket/deleteTicketImage', [TransportationTicketController::class,'deleteTicketImage'])->name('transportationticket/deleteTicketImage');

// Transportation Ticket Shippers
// Route::post('transportationticket/shipper/add', [TransportationTicketController::class,'add_transportation_shipper'])->name('transportationticket/shipper/add');
// Route::post('transportationticket/shipper/update', [TransportationTicketController::class,'update_transportation_shipper'])->name('transportationticket/shipper/update');
Route::post('transportationticket/shipper/delete', [TransportationTicketController::class,'delete_shipper'])->name('transportationticket/shipper/delete');
Route::post('transportationticket/shipper/view', [TransportationTicketController::class,'get_specific_shipper'])->name('transportationticket/shipper/view');

// Transportation Ticket Customers
// Route::post('transportationticket/customer/add', [TransportationTicketController::class,'add_transportation_customer'])->name('transportationticket/customer/add');
// Route::post('transportationticket/customer/update', [TransportationTicketController::class,'update_transportation_customer'])->name('transportationticket/customer/update');
Route::post('transportationticket/customer/delete', [TransportationTicketController::class,'delete_customer'])->name('transportationticket/customer/delete');
Route::post('transportationticket/customer/view', [TransportationTicketController::class,'get_specific_customer'])->name('transportationticket/customer/view');











});
