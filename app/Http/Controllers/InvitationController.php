<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRaquest;
use App\Mail\InvitationEmail;
use App\Models\Flatshare;
use App\Models\Invitation;
use DB;
use Mail;
use Str;

class InvitationController extends Controller
{
    public function create(string $flatshareId)
    {
        return view('flatshare.invitation.create', compact('flatshareId'));
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

    public function refuse(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $invitation->update([
            'status' => 'refused',
        ]);

        return redirect()->route('flatshare.index');
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $flatshare = Flatshare::findOrFail($invitation->flatshare_id);
        $user = auth()->user();

        $alreadyMember = $flatshare->users()
            ->where('user_id', $user->id)
            ->wherePivotNull('left_at')
            ->exists();

        if ($alreadyMember) {
            return back()->with('error', 'You are already a member of this flatshare');
        }

        $hasActiveFlatshare = $user->flatshares()
            ->wherePivotNull('left_at')
            ->exists();

        if ($hasActiveFlatshare) {
            return back()->with('error', 'You already belong to an active flatshare');
        }

        if ($invitation->status !== 'pending') {
            return back()->with('error', 'This invitation is no longer valid');
        }

        DB::transaction(function () use ($invitation, $flatshare, $user) {

            $invitation->update([
                'status' => 'accepted',
            ]);

            $flatshare->users()->attach($user->id, [
                'internal_role' => 'member',
                'joined_at' => now(),
                'left_at' => null,
            ]);
        });

        return redirect("/flatshare/show/$flatshare->id")
            ->with('success', 'You have successfully joined the flatshare');
    }

    public function process(string $token)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (! Auth()->check() || $invitation->email !== Auth()->user()->email) {
            return redirect()->route('login');
        }

        return view('flatshare.invitation.process', compact('token'));
    }
}
