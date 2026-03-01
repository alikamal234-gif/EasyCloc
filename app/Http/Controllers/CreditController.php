<?php

namespace App\Http\Controllers;

use App\Models\Flatshare;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flatshare = Flatshare::with([
            'users' => function ($query) {
                $query->wherePivotNull('left_at');
            },
            'expenses.user',
            'payments',
        ])->findOrFail($id);

        $total = $flatshare->expenses->sum('amount');
        $membersCount = $flatshare->users->count();
        $share = $membersCount > 0 ? $total / $membersCount : 0;

        $balances = [];
        
        foreach ($flatshare->users as $user) {

            $paidExpenses = $flatshare->expenses
                ->where('user_id', $user->id)
                ->sum('amount');

            $received = $flatshare->payments
                ->where('creditor_id', $user->id)
                ->sum('amount');

            $given = $flatshare->payments
                ->where('debtor_id', $user->id)
                ->sum('amount');

           $balance = $paidExpenses - $share + $received - $given;
            $balances[] = [
                'user' => $user,
                'balance' => round($balance, 2),
            ];
        }

        $creditors = collect($balances)->where('balance', '>', 0);
        $debtors = collect($balances)->where('balance', '<', 0);
        $settlements = [];

        foreach ($debtors as $debtor) {

            $remainingDebt = abs($debtor['balance']);

            foreach ($creditors as $creditor) {

                if ($remainingDebt <= 0) {
                    break;
                }
                if ($creditor['balance'] <= 0) {
                    continue;
                }

                $amount = min($remainingDebt, $creditor['balance']);

                $settlements[] = [
                    'from' => $debtor['user'],
                    'to' => $creditor['user'],
                    'amount' => round($amount, 2),
                ];
                $remainingDebt -= $amount;
            }
        }
        return view('flatshare.credit', compact(
            'flatshare',
            'settlements',
            'total',
            'share'
        ));
    }
}
