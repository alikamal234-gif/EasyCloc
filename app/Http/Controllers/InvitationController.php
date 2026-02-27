<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRaquest;
use App\Mail\InvitationEmail;
use App\Models\Flatshare;
use App\Models\Invitation;
use DB;
use Illuminate\Http\Request;
use Mail;
use Str;

class InvitationController extends Controller
{
    public function create(string $flatshareId){
        return view('flatshare.invitation.create',compact('flatshareId'));
    }
    public function send(InvitationRaquest $request)
    {
        $data = $request->validated();
        $data['status'] = 'pending';
        $data['token'] = Str::random(60);
        Mail::to($data['email'])->send(new InvitationEmail($data['token']));
        Invitation::create($data);
        return redirect()->back();
    }

    public function refuse(string $token) {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $invitation->update([
                'status' => 'refused'
            ]);
        return redirect()->route('flatshare.index');
    }

    public function accept(string $token)
    {
    
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $flatshare = Flatshare::findOrFail($invitation->flatshare_id);

    
        DB::transaction(function () use ($invitation,$flatshare){
            $invitation->update([
                'status' => 'accepted'
            ]);
            $flatshare->users()->attach(auth()->id(),[
                'internal_role' => 'member',
                'joined_at' => now()
            ]);
        });
        return redirect("/flatshare/show/$flatshare->id");
    }

    public function process(string $token) {
        $invitation = Invitation::where('token',$token)->first();
        
        if(!Auth()->check() || $invitation->email !== Auth()->user()->email){
            return redirect()->route('login');
        }
        return view('flatshare.invitation.process',compact('token'));
    }
}
