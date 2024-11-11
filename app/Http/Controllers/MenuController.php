<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\JenisUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MenuController extends Controller
{
    public function index()
    {
        // $users = User::all();
        $menus = Menu::all();
        $jenisusers = JenisUsers::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('admin.menu.menu', ['menus'=>$menus, 'menu' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);
    }

    public function edit($id)
    {
        $menus = Menu::findOrFail($id);
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('admin.menu.edit', ['menus'=>$menus ,'assignedMenus' => $assignedMenus]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'menu_name' => 'required|string|max:60',
        'menu_link' => 'required|string|max:60',
        'menu_icon' => 'required|string|max:200',
        'id_level' => 'nullable|exists:menu_levels,id',
    ]);

    $menus = Menu::findOrFail($id);

    // Update user details
    $menus->menu_name = $request->input('menu_name');
    $menus->menu_link = $request->input('menu_link');
    $menus->menu_icon = $request->input('menu_icon');
    $menus->parent_id = $request->input('parent_id');

    $menus->save();

    return redirect()->back()->with('success', 'User updated successfully.');

    }


    public function destroy($id)
{
    $menu = Menu::findOrFail($id);

    if ($menu->users()->count() > 0) {
        return redirect()->back()->with('error', 'Menu cannot be deleted because it is still linked to users.');
    }

    $menu->delete();

    return redirect()->back()->with('success', 'Menu deleted successfully.');
}

    public function store(Request $request)
    {

        Menu::create([
            'menu_name' => $request->menu_name,
            'menu_link' => $request->menu_link,
            'menu_icon' => $request->menu_icon,
            'parent_id' => $request->parent_id,
            'id_level'  => $request->id_level ?? 1,
            'create_by' => Auth::user()->username,
            'update_by' => Auth::user()->username,
        ]);

        return redirect()->back()->with('success', 'User successfully added!');
    }

}

