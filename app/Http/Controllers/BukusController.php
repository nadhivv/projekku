<?php

namespace App\Http\Controllers;

use App\Models\Bukus;
use App\Models\JenisUsers;
use App\Models\Kategoris;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BukusController extends Controller
{

    public function index()
    {
        $bukus = Bukus::all();
        $kategoris = Kategoris::all();
        $menus = Menu::all();
        $jenisusers = JenisUsers::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();

        return view('halaman.buku', ['bukus'=>$bukus, 'kategoris' => $kategoris,
        'assignedMenus' => $assignedMenus,
        'jenisusers' => $jenisusers]);
    }


    public function store(Request $request)
    {

        Bukus::create([
            'judul' => $request->input('judul'),
            'pengarang' => $request->input('pengarang'),
            'kode' => $request->input('kode'),
            'id_kategori' => $request->input('id_kategori'),
            ]);

            return redirect()->back()->with('buku berhasil ditambahkan');
    }
    public function destroy($id)
    {
        $bukus = Bukus::findOrFail($id);
        $bukus->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    public function edit($id)
    {

        $bukus = Bukus::findOrFail($id);
        $kategoris = Kategoris::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('halaman.bukuedit', ['bukus'=>$bukus, 'kategoris' => $kategoris,
        'assignedMenus' => $assignedMenus]);

    }

    public function update(Request $request, $id)
{
    $bukus = Bukus::findOrFail($id);

    // Update user details
    $bukus->id_kategori = $request->input('id_kategori');
    $bukus->judul = $request->input('judul');
    $bukus->kode = $request->input('kode');
    $bukus->pengarang = $request->input('pengarang');
    $bukus->save();

    return redirect()->back()->with('success', 'User updated successfully.');

    }
}
