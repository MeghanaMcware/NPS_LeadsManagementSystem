<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    public function show(?Lead $lead = null): View
    {
        $lead = $lead ?? Lead::query()->latest('id')->first();
        if (! $lead) {
            abort(404, 'No leads found.');
        }

        $lead->load(['messages' => function ($query) {
            $query->orderBy('sent_at', 'desc');
        }]);

        return view('admin.leads.view', compact('lead'));
    }

    /**
     * Store a new note on the lead.
     */
    public function storeNote(Request $request, Lead $lead): JsonResponse
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:1000'],
        ]);

        $author = auth()->user()?->name ?? 'Admin';
        $lead->addNote($validated['note'], $author, 'note');

        // Also record in communication messages timeline
        $msg = $lead->messages()->create([
            'channel' => 'note',
            'note' => $validated['note'],
            'status' => 'saved',
            'sent_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note saved successfully.',
            'note' => [
                'text' => $validated['note'],
                'author' => $author,
                'date' => now()->format('d M Y, h:i A'),
                'type' => 'note',
            ],
            'remarks' => $lead->remarks,
        ]);
    }

    /**
     * Delete a note from the lead remarks JSON array.
     */
    public function deleteNote(Lead $lead, int $index): JsonResponse
    {
        $notes = is_array($lead->remarks) ? $lead->remarks : [];

        if (isset($notes[$index])) {
            array_splice($notes, $index, 1);
            $lead->remarks = $notes;
            $lead->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully.',
            'remarks' => $lead->remarks,
        ]);
    }

    /**
     * Update the lead's status.
     */
    public function updateStatus(Request $request, Lead $lead): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,contacted,followup,converted'],
        ]);

        $lead->status = $validated['status'];
        $lead->last_contact_at = now();
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $lead->status,
        ]);
    }
}
