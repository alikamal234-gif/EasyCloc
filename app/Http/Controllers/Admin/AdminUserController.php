<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{

    public function index()
    {
        $users = User::latest()->paginate(20);

        return view('admin.users', compact('users'));
    }


    public function ban($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_banned' => true
        ]);

        return back()->with('success','User banned successfully');
    }


    public function unban($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_banned' => false
        ]);

        return back()->with('success','User unbanned successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return back()->with('success','User deleted successfully');
    }
}