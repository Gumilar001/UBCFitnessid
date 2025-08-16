<?php

namespace App\Http\Controllers;

use App\Models\UserMembership;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;

class UserMembershipController extends Controller
{
    public function index()
    {
        $userMemberships = UserMembership::with(['user', 'membership'])->get();
        return view('user_memberships.index', compact('userMemberships'));
    }

    public function create()
    {
        $users = User::all();
        $memberships = Membership::all();
        return view('user_memberships.create', compact('users', 'memberships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,expired,cancelled',
        ]);
        UserMembership::create($request->all());
        return redirect()->route('user-memberships.index')->with('success', 'User Membership created!');
    }

    public function edit(UserMembership $userMembership)
    {
        $users = User::all();
        $memberships = Membership::all();
        return view('user_memberships.edit', compact('userMembership', 'users', 'memberships'));
    }

    public function update(Request $request, UserMembership $userMembership)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,expired,cancelled',
        ]);
        $userMembership->update($request->all());
        return redirect()->route('user-memberships.index')->with('success', 'User Membership updated!');
    }

    public function destroy(UserMembership $userMembership)
    {
        $userMembership->delete();
        return redirect()->route('user-memberships.index')->with('success', 'User Membership deleted!');
    }

    public function myMemberships()
    {
        $memberships = UserMembership::where('user_id', auth()->id())->get();
        return view('users.memberships.index', compact('memberships'));
    }

}