<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadImportController;
use App\Models\Lead;
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

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/leads/index', [LeadController::class, 'index'])->name('leads.index');

    Route::get('/leads/view/{lead?}', function (?Lead $lead = null) {
        $lead = $lead ?? Lead::query()->latest('id')->first();
        if (! $lead) {
            return redirect()->route('leads.index');
        }

        return view('admin.leads.view', compact('lead'));
    })->name('leads.view');

    // Add & Bulk Import routes
    Route::get('/leadsimport/index', [LeadImportController::class, 'index'])->name('leadsimport.index');
    Route::get('/leadsimport/sample', [LeadImportController::class, 'downloadSample'])->name('leadsimport.sample');
    Route::post('/leadsimport/preview', [LeadImportController::class, 'preview'])->name('leadsimport.preview');
    Route::post('/leadsimport/process', [LeadImportController::class, 'process'])->name('leadsimport.process');
    Route::post('/leadsimport/single', [LeadImportController::class, 'storeSingle'])->name('leadsimport.single');

    Route::get('/sendmessage/index', function () {
        return view('admin.sendmessage.index');
    })->name('sendmessage.index');
});


Route::get('/', function () {
    return view('frontend.first');
})->name('home');

Route::get('/life-at-npskgl', function () {
    return view('frontend.life_at_npskgl');
})->name('life_at_npskgl');

Route::get('/life_at_npskgl', function () {
    return redirect()->route('life_at_npskgl');
});

Route::get('/activities', function () {
    return view('frontend.activities');
})->name('activities');
