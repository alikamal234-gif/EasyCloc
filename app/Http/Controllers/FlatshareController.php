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
        $flatshares = $user->flatshares;
        $is_can = true;
        foreach ($user->flatshares as $flatshare) {
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
          $members = $flatshare->users()->count();
       

        return view('flatshare.show', compact('flatshare','members'));
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
      
        if($flatshare->users()->count() > 1){
            return abort(404);
        }
        $flatshare->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('flatshare.index');
    }
}
