<?php

use Illuminate\Support\Facades\Route;


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