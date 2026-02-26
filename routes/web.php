<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FlatshareController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/flatshare', [FlatshareController::class, 'index'])->name('flatshare.index');
    Route::get('/flatshare/create', [FlatshareController::class, 'create'])->name('flatshare.create');
    Route::get('/flatshare/edit/{id}', [FlatshareController::class, 'edit'])->name('flatshare.edit');
    Route::get('/flatshare/show/{id}', [FlatshareController::class, 'show'])->name('flatshare.show');

    Route::post('/flatshare/store', [FlatshareController::class, 'store'])->name('flatshare.store');
    Route::put('/flatshare/update/{id}', [FlatshareController::class, 'update'])->name('flatshare.update');
    // Route::delete('/flatshare/destroy/{id}', [FlatshareController::class, 'destroy'])->name('flatshare.destroy');
    Route::put('/flatshare/{id}/cancel',[FlatshareController::class, 'cancel'])->name('flatshare.cancel');

    // expense
    Route::get('/flatshare/expense/create/{id}', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/flatshare/expense/store/{id}', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/flatshare/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::put('/flatshare/expense/update/{id}', [ExpenseController::class, 'update'])->name('expense.update');


});

require __DIR__.'/auth.php';
