<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForgetPasswordController;


Route::get('/', function () {
    return redirect('/login');// view('welcome');
});
Route::group(['prefix' => '/'], function () {
    
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/loginSubmit', [AdminController::class, 'loginSubmit'])->name('loginSubmit');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/forget_password', [ForgetPasswordController::class, 'forget_password'])->name('forget_password');
    Route::post('/forget_password/otp', [ForgetPasswordController::class, 'forgetPassword_step1'])->name('forget_password.step1');
    Route::post('/forget_password/reset', [ForgetPasswordController::class, 'forgetPassword_step2'])->name('forget_password.step2');
    Route::post('/forget_password/change', [ForgetPasswordController::class, 'forgetPassword_step3'])->name('forget_password.step3');

   

    Route::group(['middleware' => ['AdminAuth']], function () {

        /************** PAGE ROUTES ******************/
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs');
        Route::get('/rigger_tickets', [AdminController::class, 'rigger_tickets'])->name('rigger_tickets');
        Route::get('/transportation', [AdminController::class, 'transportation'])->name('transportation');
        Route::get('/pay_duty', [AdminController::class, 'pay_duty'])->name('pay_duty');
        Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
        
        /************** AJAX ROUTES ******************/
        Route::post('/admin/getProfilePageData', [AdminController::class, 'getProfilePageData'])->name('admin.getProfilePageData');
        Route::post('/admin/updateAdminProfile', [AdminController::class, 'updateAdminProfile'])->name('admin.updateAdminProfile');
        
        Route::post('/admin/getUsersPageData', [AdminController::class, 'getUsersPageData'])->name('admin.getUsersPageData');
        Route::post('/admin/saveUserData', [AdminController::class, 'saveUserData'])->name('admin.saveUserData');
        Route::post('/admin/changeUserStatus', [AdminController::class, 'changeUserStatus'])->name('admin.changeUserStatus');
        Route::post('/admin/getSpecificUserDetails', [AdminController::class, 'getSpecificUserDetails'])->name('admin.getSpecificUserDetails');
        Route::post('/admin/searchAdminListing', [AdminController::class, 'searchAdminListing'])->name('admin.searchAdminListing');
        Route::post('/admin/deleteSpecificUser', [AdminController::class, 'deleteSpecificUser'])->name('admin.deleteSpecificUser');
        
        Route::post('/admin/getDashboardPageData', [AdminController::class, 'getDashboardPageData'])->name('admin.getDashboardPageData');
        Route::post('/admin/saveJobData', [AdminController::class, 'saveJobData'])->name('admin.saveJobData');
        Route::get('/admin/getAllJobs', [AdminController::class, 'getAllJobs'])->name('admin.getAllJobs');
        Route::post('/admin/changeJobStatus', [AdminController::class, 'changeJobStatus'])->name('admin.changeJobStatus');
        Route::post('/admin/viewJobDetails', [AdminController::class, 'viewJobDetails'])->name('admin.viewJobDetails');
        Route::post('/admin/deleteSpecificJob', [AdminController::class, 'deleteSpecificJob'])->name('admin.deleteSpecificJob');
        Route::post('/admin/searchJobsListing', [AdminController::class, 'searchJobsListing'])->name('admin.searchJobsListing');
        
        Route::post('/admin/getJobsPageData', [AdminController::class, 'getJobsPageData'])->name('admin.getJobsPageData');
        Route::post('/admin/getRiggerTicketPageData', [AdminController::class, 'getRiggerTicketPageData'])->name('admin.getRiggerTicketPageData');
        Route::post('/admin/searchRiggerTicketListing', [AdminController::class, 'searchRiggerTicketListing'])->name('admin.searchRiggerTicketListing');
        Route::post('/admin/viewRiggerTicketDetails', [AdminController::class, 'viewRiggerTicketDetails'])->name('admin.viewRiggerTicketDetails');
        Route::post('/admin/deleteSpecificRiggerTicket', [AdminController::class, 'deleteSpecificRiggerTicket'])->name('admin.deleteSpecificRiggerTicket');
        
        Route::post('/admin/getTransporterTicketPageData', [AdminController::class, 'getTransporterTicketPageData'])->name('admin.getTransporterTicketPageData');
        Route::post('/admin/viewTransporterTicketDetails', [AdminController::class, 'viewTransporterTicketDetails'])->name('admin.viewTransporterTicketDetails');
        Route::post('/admin/searchTransporterTicketListing', [AdminController::class, 'searchTransporterTicketListing'])->name('admin.searchTransporterTicketListing');
        Route::post('/admin/deleteSpecificTransportationTicket', [AdminController::class, 'deleteSpecificTransportationTicket'])->name('admin.deleteSpecificTransportationTicket');
        
        Route::post('/admin/getPayDutyPageData', [AdminController::class, 'getPayDutyPageData'])->name('admin.getPayDutyPageData');
        Route::post('/admin/viewPayDutyFormDetails', [AdminController::class, 'viewPayDutyFormDetails'])->name('admin.viewPayDutyFormDetails');
        Route::post('/admin/searchPayDutyListing', [AdminController::class, 'searchPayDutyListing'])->name('admin.searchPayDutyListing');
        Route::post('/admin/deleteSpecificPayDutyForm', [AdminController::class, 'deleteSpecificPayDutyForm'])->name('admin.deleteSpecificPayDutyForm');
        
        Route::post('/admin/saveInventoryData', [AdminController::class, 'saveInventoryData'])->name('admin.saveInventoryData');
        Route::post('/admin/getInventoryPageData', [AdminController::class, 'getInventoryPageData'])->name('admin.getInventoryPageData');
        Route::post('/admin/getSpecificInventoryDetails', [AdminController::class, 'getSpecificInventoryDetails'])->name('admin.getSpecificInventoryDetails');
        Route::post('/admin/searchInventoryListing', [AdminController::class, 'searchInventoryListing'])->name('admin.searchInventoryListing');
        Route::post('/admin/deleteSpecificInventory', [AdminController::class, 'deleteSpecificInventory'])->name('admin.deleteSpecificInventory');
        
        

        Route::get('/emailRiggerPdf', function () {
            $pageTitle = 'Dashboard';
            return view('admin/emailRiggerPdf', compact('pageTitle'));
        });
        
        Route::post('/sendtomailRigger', [AdminController::class, 'sendtomailRigger'])->name('sendtomailRigger');

        
    });
});





// Route::get('/dashboard', function () {
//     $pageTitle = 'Dashboard';
//     return view('admin/dashboard', compact('pageTitle'));
// });

// Route::get('/all_jobs', function () {
//     $pageTitle = 'All-jobs';
//     return view('admin/all_jobs', compact('pageTitle'));
// });

// Route::get('/add_job', function () {    
//     $pageTitle = 'Add-jobs';
//     return view('admin/add_job', compact('pageTitle'));
// });

// Route::get('/add_user', function () {
//     $pageTitle = 'Add-users';
//     return view('admin/add_user', compact('pageTitle'));
// });

Route::get('/admins', function () {
    $pageTitle = 'Admins';
    return view('admin/admins', compact('pageTitle'));
});

Route::get('/managers', function () {
    $pageTitle = 'Managers';
    return view('admin/managers', compact('pageTitle'));
});

Route::get('/basic_user', function () {
    $pageTitle = 'Basic_user';
    return view('admin/basic_user', compact('pageTitle'));
});

// Route::get('/rigger_tickets', function () {
//     $pageTitle = 'Rigger_tickets';
//     return view('admin/rigger_tickets', compact('pageTitle'));
// });

// Route::get('/transportation', function () {
//     $pageTitle = 'Transportation';
//     return view('admin/transportation', compact('pageTitle'));
// });

// Route::get('/pay_duty', function () {
//     $pageTitle = 'Pay_duty';
//     return view('admin/pay_duty', compact('pageTitle'));
// });

// Route::get('/pay_duty_add_form', function () {
//     $pageTitle = 'Pay_duty_add_form';
//     return view('admin/pay_duty_add_form', compact('pageTitle'));
// });

// Route::get('/inventory', function () {
//     $pageTitle = 'Inventory';
//     return view('admin/inventory', compact('pageTitle'));
// });

// Route::get('/inventory_form', function () {
//     $pageTitle = 'InventoryForm';
//     return view('admin/inventory_form', compact('pageTitle'));
// });

// Route::get('/profile', function () {
//     $pageTitle = 'Profile';
//     return view('admin/profile', compact('pageTitle'));
// });

Route::get('/notification', function () {
    $pageTitle = 'Notification';
    return view('admin/notification', compact('pageTitle'));
});

Route::get('/web_api_users', function () {
    $pageTitle = 'Web_api_users';
    return view('admin/web_api_users', compact('pageTitle'));
});

Route::get('/web_api_add_job', function () {
    $pageTitle = 'Web_api_add_job';
    return view('admin/web_api_add_job', compact('pageTitle'));
});

Route::get('/web_api_rigger', function () {
    $pageTitle = 'Web_api_rigger';
    return view('admin/web_api_rigger', compact('pageTitle'));
});

Route::get('/web_api_payduty', function () {
    $pageTitle = 'Web_api_payduty';
    return view('admin/web_api_payduty', compact('pageTitle'));
});

Route::get('/web_api_transportation', function () {
    $pageTitle = 'Web_api_transportation';
    return view('admin/web_api_transportation', compact('pageTitle'));
});