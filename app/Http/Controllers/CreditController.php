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
    $flatshare = Flatshare::with(['users', 'expenses.user'])
        ->findOrFail($id);

    $total = $flatshare->expenses->sum('amount');
    $membersCount = $flatshare->users->count();
    $share = $membersCount > 0 ? $total / $membersCount : 0;

    $balances = [];

    foreach ($flatshare->users as $user) {

        $paid = $flatshare->expenses
            ->where('user_id', $user->id)
            ->sum('amount');

        $balances[] = [
            'user' => $user,
            'balance' => round($paid - $share, 2),
        ];
    }

    $creditors = collect($balances)->where('balance', '>', 0);
    $debtors   = collect($balances)->where('balance', '<', 0);

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
                'to'   => $creditor['user'],
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
