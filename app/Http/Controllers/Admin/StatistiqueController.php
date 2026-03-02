<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Flatshare;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index()
    {
        $totalUsers       = User::count();
        $bannedUsers      = User::where('is_banned', 1)->count();
        $activeUsers      = User::where('is_banned', 0)->count();

        $totalFlatshares  = Flatshare::count();
        $activeFlatshares = Flatshare::where('status', 'active')->count();
        $cancelledFlatshares = Flatshare::where('status', 'cancelled')->count();

        $totalExpenses = Expense::count();
        $totalAmount   = Expense::sum('amount');

        $totalPayments = Payment::count();
        $totalPaid     = Payment::sum('amount');

        $totalCategories = Category::count();

        $topSpenders = User::withSum('expenses as total_spent', 'amount')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();

        $topFlatshares = Flatshare::withCount('expenses')
            ->orderByDesc('expenses_count')
            ->take(5)
            ->get();

     

        return view('admin.index', compact(
            'totalUsers',
            'bannedUsers',
            'activeUsers',
            'totalFlatshares',
            'activeFlatshares',
            'cancelledFlatshares',
            'totalExpenses',
            'totalAmount',
            'totalPayments',
            'totalPaid',
            'totalCategories',
            'topSpenders',
            'topFlatshares',
        ));
    }
}