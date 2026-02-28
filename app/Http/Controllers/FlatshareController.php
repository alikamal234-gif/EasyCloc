<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlatshareRequest;
use App\Models\Flatshare;
use DB;

class FlatshareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $flatshares = $user->flatshares()->wherePivotNull('left_at')->get();
        $is_can = true;
        foreach ($flatshares as $flatshare) {
            if ($flatshare->status == 'active') {
                $is_can = false;
            }
        }

        return view('flatshare.index', compact('flatshares', 'is_can'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('flatshare.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlatshareRequest $request)
    {

        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $flatshare = Flatshare::create($data);
            $flatshare->users()->attach(auth()->id(), [
                'internal_role' => 'owner',
                'joined_at' => now(),
            ]);
        });

        return redirect()->route('flatshare.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flatshare = Flatshare::with(['expenses.user', 'expenses.category'])
            ->findOrFail($id);
        if (! $flatshare->users->contains(auth()->id())) {
            abort(403);
        }
        $members = $flatshare->users()->get();
        return view('flatshare.show', compact('flatshare', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flatshare = Flatshare::find($id);

        return view('flatshare.edit', compact('flatshare'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FlatshareRequest $request, string $id)
    {
        $flatshare = Flatshare::find($id);
        $data = $request->validated();
        $flatshare->update($data);

        return redirect()->route('flatshare.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flatshare = Flatshare::findOrFail($id);

        $flatshare->delete();

        return redirect()->route('flatshare.index');
    }

    public function cancel(string $id)
    {
        $flatshare = Flatshare::findOrFail($id);

        if (
            $flatshare->users()
                ->where('user_id', auth()->id())
                ->wherePivot('internal_role', 'owner')
                ->doesntExist()
        ) {
            abort(403);
        }

        if ($flatshare->users()->count() > 1) {
            return abort(404);
        }
        $flatshare->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('flatshare.index');
    }

    public function exit(string $flatshareId)
    {
        $flatshare = Flatshare::with(['users', 'expenses.user', 'payments'])
            ->findOrFail($flatshareId);

        $user = auth()->user();

        $pivotUser = $flatshare->users()
            ->where('user_id', $user->id)
            ->wherePivotNull('left_at')
            ->first();

        if (! $pivotUser) {
            abort(403);
        }

        if ($pivotUser->pivot->internal_role === 'owner') {
            return back()->with('error', 'Owner must transfer ownership first.');
        }


        $total = $flatshare->expenses->sum('amount');
        $membersCount = $flatshare->users()
            ->wherePivotNull('left_at')
            ->count();

        $share = $membersCount > 0 ? $total / $membersCount : 0;

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

        DB::transaction(function () use ($flatshare, $user, $balance) {

            if ($balance < 0) {
                $user->decrement('reputation_score', 1);
            }
            
            $flatshare->users()->updateExistingPivot(
                $user->id,
                ['left_at' => now()]
            );
        });

        return redirect()->route('flatshare.index')
            ->with('success', 'You have left the flatshare.');
    }
}
