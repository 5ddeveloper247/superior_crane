<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::group(['prefix' => '/'], function () {

    Route::get('/', [AdminController::class, 'login'])->name('/');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/loginSubmit', [AdminController::class, 'loginSubmit'])->name('admin.loginSubmit');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/noaccess', [AdminController::class, 'noaccess'])->name('admin.noaccess');

    Route::group(['middleware' => ['AdminAuth']], function () {

        /************** PAGE ROUTES ******************/
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('check.subadmin.access:true');
        Route::get('/admin_user', [AdminController::class, 'adminUser'])->name('admin.admin_user');
        Route::get('/subscription', [AdminController::class, 'subscription'])->name('admin.subscription');
        Route::get('/landlord', [AdminController::class, 'landlord'])->name('admin.landlord');
        Route::get('/tenant', [AdminController::class, 'tenant'])->name('admin.tenant');
        Route::get('/api_settings', [AdminController::class, 'apiSettings'])->name('admin.api_settings');
        Route::get('/user_payments', [AdminController::class, 'userPayments'])->name('admin.user_payments');
        Route::get('/user_subscriptions', [AdminController::class, 'userSubscriptions'])->name('admin.user_subscriptions');
        Route::get('/contact_us', [AdminController::class, 'contactUs'])->name('admin.contact_us');
        Route::get('/my_account', [AdminController::class, 'my_account'])->name('admin.my_account');
        
        Route::get('/property_matches', [AdminController::class, 'propertyMatches'])->name('admin.property_matches');
        
        // Route::get('/enquiry_process', [AdminController::class, 'enquiryProcess'])->name('admin.enquiry_process');
        Route::get('/required_documents', [AdminController::class, 'required_documents'])->name('admin.required_documents');
        Route::get('/enquiry_requests', [AdminController::class, 'enquiry_requests'])->name('admin.enquiry_requests');
            
        
        /************** AJAX ROUTES ******************/
        // Route::post('/editSpecificPlan', [AdminController::class, 'editSpecificPlan'])->name('admin.editSpecificPlan');
       
        
        
    });
});

Route::get('/', function () {
    $pageTitle = 'Login';
    return view('admin/login_form', compact('pageTitle'));
});

Route::get('/forget_password', function () {
    $pageTitle = 'Forget Password';
    return view('admin/forget_password', compact('pageTitle'));
});

Route::get('/dashboard', function () {
    $pageTitle = 'Dashboard';
    return view('admin/dashboard', compact('pageTitle'));
});

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

Route::get('/profile', function () {
    $pageTitle = 'Profile';
    return view('admin/profile', compact('pageTitle'));
});

Route::get('/notification', function () {
    $pageTitle = 'Notification';
    return view('admin/notification', compact('pageTitle'));
});

Route::get('/web_api_users', function () {
    $pageTitle = 'Web_api_users';
    return view('admin/web_api_users', compact('pageTitle'));
});