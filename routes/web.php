<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.auth.login');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/leads/index', function () {
    return view('admin.leads.index');
});
Route::get('/leads/view', function () {
    return view('admin.leads.view');
});

Route::get('/leadsimport/index', function () {
    return view('admin.leadsimport.index');
});

Route::get('/sendmessage/index', function () {
    return view('admin.sendmessage.index');
});
