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
       
        /************** AJAX ROUTES ******************/
        Route::post('/admin/getProfilePageData', [AdminController::class, 'getProfilePageData'])->name('admin.getProfilePageData');
        Route::post('/admin/updateAdminProfile', [AdminController::class, 'updateAdminProfile'])->name('admin.updateAdminProfile');
        
        
        
    });
});





// Route::get('/dashboard', function () {
//     $pageTitle = 'Dashboard';
//     return view('admin/dashboard', compact('pageTitle'));
// });

Route::get('/all_jobs', function () {
    $pageTitle = 'All-jobs';
    return view('admin/all_jobs', compact('pageTitle'));
});

Route::get('/add_job', function () {    
    $pageTitle = 'Add-jobs';
    return view('admin/add_job', compact('pageTitle'));
});

Route::get('/add_user', function () {
    $pageTitle = 'Add-users';
    return view('admin/add_user', compact('pageTitle'));
});

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

Route::get('/rigger_tickets', function () {
    $pageTitle = 'Rigger_tickets';
    return view('admin/rigger_tickets', compact('pageTitle'));
});

Route::get('/transportation', function () {
    $pageTitle = 'Transportation';
    return view('admin/transportation', compact('pageTitle'));
});

Route::get('/pay_duty', function () {
    $pageTitle = 'Pay_duty';
    return view('admin/pay_duty', compact('pageTitle'));
});

Route::get('/pay_duty_add_form', function () {
    $pageTitle = 'Pay_duty_add_form';
    return view('admin/pay_duty_add_form', compact('pageTitle'));
});

Route::get('/inventory', function () {
    $pageTitle = 'Inventory';
    return view('admin/inventory', compact('pageTitle'));
});

Route::get('/inventory_form', function () {
    $pageTitle = 'InventoryForm';
    return view('admin/inventory_form', compact('pageTitle'));
});

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