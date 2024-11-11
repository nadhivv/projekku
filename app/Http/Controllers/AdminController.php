<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisUsers;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('admin.dashboard', ['users'=>$users,'menus' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);

    }
    public function list()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('admin.userlist', ['users'=>$users,'menus' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);

    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        $jenisusers = JenisUsers::all();
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('admin.useredit', ['users'=>$users,'menus' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_user' => 'required|string|max:60',
        'username' => 'required|string|max:60',
        'email' => 'required|email|max:200',
        'no_hp' => 'nullable|string|max:30',
        'id_jenis_user' => 'required|exists:jenis_users,id',
        'password' => 'nullable|string|min:4',
    ]);

    $user = User::findOrFail($id);

    // Update user details
    $user->nama_user = $request->input('nama_user');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->no_hp = $request->input('no_hp');
    $user->id_jenis_user = $request->input('id_jenis_user');

    // Update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    $user->save();

    return redirect()->back()->with('success', 'User updated successfully.');

    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');

    }

    public function store(Request $request)
    {

        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'id_jenis_user' => $request->id_jenis_user,
            'status_user' => 'active',
            'delete_mark' => 'N',
            'create_by' => Auth::user()->username,
            'update_by' => Auth::user()->username,
        ]);

        return redirect()->back()->with('success', 'User successfully added!');
    }
}



