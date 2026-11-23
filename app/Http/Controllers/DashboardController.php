<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with real lead metrics and source cards.
     */
    public function index(): View
    {
        $totalLeads = Lead::count();

        // 4 Core Source counts requested: WhatsApp, Facebook / Meta, Call, Walk-in
        $whatsappCount = Lead::query()
            ->where('source', 'like', '%whatsapp%')
            ->count();

        $facebookCount = Lead::query()
            ->where(function ($query) {
                $query->where('source', 'Meta Leads')
                    ->orWhere('source', 'Facebook')
                    ->orWhere('source', 'like', '%meta%');
            })
            ->count();

        $callCount = Lead::query()
            ->where('source', 'like', '%call%')
            ->count();

        $walkinCount = Lead::query()
            ->where('source', 'like', '%walk%')
            ->count();

        // Status counts for pipeline
        $statusCounts = [
            'new' => Lead::where('status', 'new')->count(),
            'contacted' => Lead::where('status', 'contacted')->count(),
            'followup' => Lead::where('status', 'followup')->count(),
            'converted' => Lead::where('status', 'converted')->count(),
        ];

        // Today's new leads
        $newToday = Lead::whereDate('created_at', today())->count();

        // Last 7 days distribution
        $daysData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('D');
            $cnt = Lead::whereDate('created_at', $date)->count();
            $daysData[] = [
                'label' => $label,
                'value' => $cnt,
            ];
        }

        // Recent leads for bottom table
        $recentLeads = Lead::latest('id')->take(6)->get();

        return view('admin.dashboard', compact(
            'totalLeads',
            'whatsappCount',
            'facebookCount',
            'callCount',
            'walkinCount',
            'statusCounts',
            'newToday',
            'daysData',
            'recentLeads'
        ));
    }
}
