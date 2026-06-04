<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers      = User::count();
        $totalAdmins     = User::where('is_admin', true)->count();
        $totalEntries    = JournalEntry::count();
        $newUsersToday   = User::whereDate('created_at', today())->count();
        $recentUsers     = User::latest()->limit(5)->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalAdmins',
            'totalEntries',
            'newUsersToday',
            'recentUsers',
        ));
    }
}
