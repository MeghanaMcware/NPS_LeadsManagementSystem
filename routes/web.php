<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendEnquiryController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadImportController;
use App\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', function () {
    return redirect()->route('admin.login');
});

Route::middleware('guest')->group(function () {
    Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/leads/index', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/view/{lead?}', [LeadController::class, 'show'])->name('leads.view');
    Route::post('/leads/{lead}/notes', [LeadController::class, 'storeNote'])->name('leads.notes.store');
    Route::delete('/leads/{lead}/notes/{index}', [LeadController::class, 'deleteNote'])->name('leads.notes.destroy');
    Route::post('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.status.update');

    // Add & Bulk Import routes
    Route::get('/leadsimport/index', [LeadImportController::class, 'index'])->name('leadsimport.index');
    Route::get('/leadsimport/sample', [LeadImportController::class, 'downloadSample'])->name('leadsimport.sample');
    Route::post('/leadsimport/preview', [LeadImportController::class, 'preview'])->name('leadsimport.preview');
    Route::post('/leadsimport/process', [LeadImportController::class, 'process'])->name('leadsimport.process');
    Route::post('/leadsimport/single', [LeadImportController::class, 'storeSingle'])->name('leadsimport.single');

    // Send Message / Communication routes
    Route::get('/messages/send', [SendMessageController::class, 'index'])->name('messages.send');
    Route::post('/messages/send', [SendMessageController::class, 'send'])->name('messages.send.dispatch');
    Route::get('/messages', fn () => redirect()->route('messages.send'))->name('messages.index');
    Route::get('/sendmessage/index', fn () => redirect()->route('messages.send', request()->query()))->name('sendmessage.index');
});

Route::get('/', function () {
    return view('frontend.first');
})->name('home');

Route::post('/enquiry', [FrontendEnquiryController::class, 'submit'])->name('frontend.enquiry.submit');

Route::get('/life-at-npskgl', function () {
    return view('frontend.life_at_npskgl');
})->name('life_at_npskgl');

Route::get('/life_at_npskgl', function () {
    return redirect()->route('life_at_npskgl');
});

Route::get('/activities', function () {
    return view('frontend.activities');
})->name('activities');
