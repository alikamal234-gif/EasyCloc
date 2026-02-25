<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlatshareRequest;
use App\Models\Flatshare;
use Illuminate\Http\Request;

class FlatshareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $flatshares = $user->flatshares();
        return view('flatshare.index',compact('flatshares'));
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
        Flatshare::create($data);
        return redirect()->route('flatshare.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flatshare = Flatshare::find($id);
        return view('flatshare.show',compact('flatshare'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flatshare = Flatshare::find($id);
        return view('flatshare.edit',compact('flatshare'));
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
        $flatshare = Flatshare::find($id);
        $flatshare->delete();
        return redirect()->route('flatshare.index');
    }
}
