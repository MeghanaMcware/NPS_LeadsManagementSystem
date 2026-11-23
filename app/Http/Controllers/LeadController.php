<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(): View
    {
        $leads = Lead::query()
            ->latest('id')
            ->get()
            ->map(function (Lead $lead): array {
                return [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'phone' => $lead->phone,
                    'city' => $lead->city,
                    'source' => $lead->source ?? 'Google Form',
                    'status' => strtolower($lead->status ?? 'new'),
                    'last' => $lead->last_contact_at ? (int) now()->diffInDays($lead->last_contact_at) : null,
                    'created' => (int) now()->diffInDays($lead->created_at),
                ];
            });

        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead): View
    {
        $lead->load('messages');

        return view('admin.leads.view', compact('lead'));
    }
}
