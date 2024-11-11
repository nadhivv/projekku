<?php

namespace App\Http\Controllers;

use App\Models\JenisUsers;
use App\Models\Kategoris;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KategorisController extends Controller
{

    public function index()
    {
        $kategoris = Kategoris::all();
        $menus = Menu::all();
        $jenisusers = JenisUsers::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();

        return view('halaman.kategori', ['kategoris'=>$kategoris
        , 'menus' => $menus,
        'assignedMenus' => $assignedMenus,
        'jenisusers' => $jenisusers]);
    }

    public function store(Request $request)
    {

        Kategoris::create([
        'nama_kategori' => $request->input('nama_kategori'),
        ]);

        return redirect()->back()->with('kategori berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $kategoris = Kategoris::findOrFail($id);
        $kategoris->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    public function edit($id)
    {

        $kategoris = Kategoris::findOrFail($id);
        $menus = Menu::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();

        return view('halaman.kategoriedit', ['kategoris'=>$kategoris,
            'menus' => $menus,
            'assignedMenus' => $assignedMenus,
        ]);
    }

    public function update(Request $request, $id)
{
    $kategoris = Kategoris::findOrFail($id);

    // Update user details
    $kategoris->nama_kategori = $request->input('nama_kategori');
    $kategoris->save();

    return redirect()->back()->with('success', 'User updated successfully.');

    }

}
