<?php

use App\Http\Controllers\Api\WhatsAppLeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group. Make something great!
|
*/

// WhatsApp Chatbot / Campaign Lead Ingestion Endpoint
Route::post('/leads/whatsapp', [WhatsAppLeadController::class, 'store'])->name('api.leads.whatsapp');
Route::post('/whatsapp/lead', [WhatsAppLeadController::class, 'store']);
