<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRaquest;
use App\Models\Expense;
use App\Models\Flatshare;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $flatshare = Flatshare::with('categories')->findOrFail($id);
        return view('flatshare.Expense.create',compact('flatshare'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRaquest $request,string $id)
    {
        $data = $request->validated();
        $data['flatshare_id'] = $id;
        $data['user_id'] = auth()->id();
        Expense::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::with('flatshare.categories')->findOrFail($id);
        return view('flatshare.Expense.edit',compact('expense'));
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
