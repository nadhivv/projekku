<?php

namespace App\Http\Controllers;

use App\Models\JenisUsers;
use App\Models\Komens;
use App\Models\Likes;
use App\Models\Menu;
use App\Models\Postings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class PostingsController extends Controller
{
    public function index()
{
    $postings = Postings::with(['komens', 'likes', 'users', 'menus'])->latest()->get();
    $menus = Menu::all();
    $jenisusers = JenisUsers::all();
    $currentUserRole = Auth::user()->id_jenis_user;
    $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
    $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();

    return view('posting', [
        'postings' => $postings,
        'menus' => $menus,
        'assignedMenus' => $assignedMenus,
        'jenisusers' => $jenisusers
    ]);
}
    public function add()
    {
        $postings = Postings::with(['komens', 'likes', 'users'])->latest()->get();
        $menus = Menu::all();
        $jenisusers = JenisUsers::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();
        return view('add', ['postings'=>$postings,'menus' => $menus,
            'assignedMenus' => $assignedMenus, 'jenisusers' => $jenisusers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'message_gambar' => 'image|nullable|max:2048',
        ]);

        $postings = new Postings();
        $postings->user_id = Auth::id(); // Get the authenticated user's ID
        $postings->message = $request->message;

        if ($request->hasFile('message_gambar')) {
            // Store the image using Laravel Storage
            $imagePath = $request->file('message_gambar')->store('images', 'public'); // Store in storage/app/public/images
            $postings->message_gambar = 'storage/' . $imagePath; // Store the relative path for the database
        }

        $postings->create_by = Auth::user()->username;
        $postings->update_by = Auth::user()->username; // Optional

        $postings->save();
        return redirect()->back()->with('success', 'Posting created successfully.');
    }


    public function destroy($id)
    {
        $posting = Postings::findOrFail($id);
        $posting->delete();

    return redirect()->back()->with('success', 'Posting deleted successfully.');
    }

    public function addLike($posting_id)
    {
            Likes::firstOrCreate([
            'user_id' => Auth::id(),
            'create_by' => Auth::user()->username,
            'posting_id' => $posting_id,
        ]);

        return redirect()->back()->with('success', 'Liked successfully.');
    }


    public function dislike($posting_id)
    {
        $like = Likes::where('user_id', Auth::id())->where('posting_id', $posting_id)->first();
        if ($like) {
            $like->delete();
        }

        return redirect()->back()->with('success', 'Unliked successfully.');
    }
    public function addComment(Request $request, $posting_id)
    {
        $request->validate([
            'komen' => 'required|string|max:255',
        ]);

        $komen = new Komens();
        $komen->user_id = Auth::id();
        $komen->posting_id = $posting_id;
        $komen->komen = $request->komen;
        $komen->create_by = Auth::user()->username;
        $komen->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
    public function discomment()
    {

    }

    public function edit($id)
{
    $posting = Postings::findOrFail($id);
    $postings = Postings::all();
    $menus = Postings::findOrFail($id);
    $currentUserRole = Auth::user()->id_jenis_user;
    $assignedMenuIds = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
    $assignedMenus = Menu::whereIn('id', $assignedMenuIds)->get();

    return view('edit', ['menus'=>$menus, 'assignedMenus' => $assignedMenus,'posting' => $posting, 'postings' => $postings]);
}

    public function update(Request $request, $id)
{

    $request->validate([
        'message' => 'required',
        'message_gambar' => 'image|nullable|max:2048',
    ]);

    $posting = Postings::findOrFail($id);
    $posting->message = $request->message;

    if ($request->hasFile('message_gambar')) {

        if ($posting->message_gambar) {
            Storage::delete(str_replace('storage/', '', $posting->message_gambar));
        }

        $imagePath = $request->file('message_gambar')->store('images', 'public');
        $posting->message_gambar = 'storage/' . $imagePath;
    }

    $posting->update_by = Auth::user()->username; // Optional
    $posting->save();

    return redirect()->back()->with('success', 'Posting updated successfully.');
}

}
