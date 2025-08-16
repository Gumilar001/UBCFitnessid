<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        // $users = User::all();
        // return view('users.index', compact('users'));
        // $users = User::paginate(10);
        // return view('users.index', compact('users'));

         $query = User::query();

    // Pencarian berdasarkan nama atau email
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    // Filter berdasarkan role
    if ($request->filled('role') && $request->role !== 'all') {
        $query->where('role', $request->role);
    }

    $users = $query->latest()->paginate(10)->withQueryString();
    $roles = ['admin', 'staff', 'user'];

    return view('users.index', compact('users', 'roles'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'staff', 'user'];
        return view('users.edit', compact('user', 'roles'));
    }

    public function create()
    {        
        $roles = ['admin', 'staff', 'user'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp'         => 'nullable|string|max:20',
            'no_emergency'  => 'nullable|string|max:20',
            'role'     => 'required|string|in:admin,staff,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'no_emergency' => $request->no_emergency,
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'no_hp'         => 'nullable|string|max:20',
            'no_emergency'  => 'nullable|string|max:20',
            'role'     => 'required|string|in:admin,staff,user', 
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->no_emergency = $request->no_emergency;
        $user->role  = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }
}
