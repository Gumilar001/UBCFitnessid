<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();
        return view('memberships.index', compact('memberships'));
    }

    public function create()
    {
        return view('memberships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        Membership::create($request->all());
        return redirect()->route('memberships.index')->with('success', 'Membership created!');
    }

    public function edit(Membership $membership)
    {
        return view('memberships.edit', compact('membership'));
    }

    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'name' => 'required',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        $membership->update($request->all());
        return redirect()->route('memberships.index')->with('success', 'Membership updated!');
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();
        return redirect()->route('memberships.index')->with('success', 'Membership deleted!');
    }
}