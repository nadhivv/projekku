<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JenisUsers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('user.dashboard', ['users'=>$users,'menus' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);

    }

    public function general()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('dashboard', ['users'=>$users,'menus' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);

    }
    public function registerview()
{
    $users = User::all();
    $jenisusers = JenisUsers::all();
    $menus = Menu::all();

    // Check if the user is authenticated
    if (Auth::check()) {
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
    } else {
        // If no user is logged in, set assignedMenus to an empty array
        $assignedMenus = [];
    }

    return view('auth.register', [
        'users' => $users,
        'menus' => $menus,
        'assignedMenus' => $assignedMenus,
        'jenisusers' => $jenisusers,
    ]);
}


public function register(Request $request)
{
    User::create([
        'nama_user' => $request->input('nama_user'),
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'no_hp' => $request->input('no_hp'),
        'id_jenis_user' => $request->input('id_jenis_user'), // Pastikan ini ada di form
        'create_by' => 'system',
        'update_by' => 'system',
        'status_user' => 'active',
        'delete_mark' => 'N'
    ]);

    return redirect('/')->with('success', 'Registration successful. Please log in.');
}


    public function loginview()
    {
        return view('auth.login');

    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            $user = Auth::user();


            if ($user->id_jenis_user == 1) {
                return redirect()->intended('/admin/dashboard')->with('success', 'Welcome Admin!');
            } else {
                return redirect()->intended('/dashboard')->with('success', 'Welcome User!');
            }
        }

        // Jika login gagal
        return redirect('/')->withErrors(['error' => 'Invalid credentials.']);
    }



      public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }




}
