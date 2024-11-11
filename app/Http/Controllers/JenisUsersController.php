<?php

namespace App\Http\Controllers;

use App\Models\JenisUsers;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $menus = Menu::all();
        $jenisusers = JenisUsers::with('menus')->get();
        $currentUserRole = Auth::user()->id_jenis_user;

        // Get the assigned menu IDs for the current user role
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();

        // Retrieve the assigned menus using the collected IDs
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();

        return view('admin.role.role', [
            'jenisusers' => $jenisusers,
            'users' => $users,
            'menus' => $menus,
            'assignedMenus' => $assignedMenus,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_user' => 'required|string|max:60',
        ]);

        JenisUsers::create([
            'jenis_user' => $request->jenis_user,
            'create_by' => Auth::user()->username,
            'update_by' => Auth::user()->username,
            'delete_mark' => 'N',
        ]);

        return redirect()->back()->with('success', 'User successfully added!');
    }

    public function edit($id)
    {
        $users = User::all();
        $jenisusers = JenisUsers::findOrFail($id);
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        $selectedMenusRole = $jenisusers->menus->pluck('id')->toArray();

        return view('admin.role.edit', [
            'users' => $users,
            'jenisusers' => $jenisusers,
            'menus' => $menus,
            'assignedMenus' => $assignedMenus,
            'selectedMenusRole' => $selectedMenusRole,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_user' => 'required|string|max:60',
            'menu_ids' => 'required|array',
        ]);

        $jenisusers = JenisUsers::findOrFail($id);
        $jenisusers->update_by = Auth::user()->username;
        $jenisusers->jenis_user = $request->input('jenis_user');
        $jenisusers->save();

        // Sync the menus with the given menu IDs
        $jenisusers->menus()->sync($request->menu_ids);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy($id)
{
    $jenisUsers = JenisUsers::findOrFail($id);

    if ($jenisUsers->users()->count() > 0) {
        return redirect()->back()->with('error', 'Jenis user tidak dapat dihapus karena masih terkait dengan pengguna.');
    }
    
    $jenisUsers->menus()->detach();
    $jenisUsers->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}
}
