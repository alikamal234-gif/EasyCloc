<?php

namespace App\Http\Controllers;

use App\Models\Flatshare;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function internalRole(string $flatshareId,string $newOwnerId){
        $flatshare = Flatshare::findOrFail($flatshareId);
        $user = User::findOrFail($newOwnerId);
        $user_auth = auth()->user();

        if($flatshare->users()->findOrFail($user_auth->id)->pivot->internal_role !== "owner"){
            return abort(403);
        }
        DB::transaction(function () use($user,$user_auth,$flatshare){
            $flatshare->users()->updateExistingPivot($user->id,[
                'internal_role' => 'owner'
            ]);

            $flatshare->users()->updateExistingPivot($user_auth->id,[
                'internal_role' => 'member'
            ]);
        });
        return redirect()->back();                                      
    }
    
    public function remove(string $flatshareId,string $userId){
        $user = User::findOrFail($userId);
        // left_at
        $flatshare = Flatshare::findOrFail($flatshareId);
        $flatshare->users()->updateExistingPivot($user->id,[
            'left_at' => now()
        ]);
        return redirect()->back();
    }
}
