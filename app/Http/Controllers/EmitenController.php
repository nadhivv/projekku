<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmitenController extends Controller
{
    public function index()
    {
        // If $assignedMenus is necessary, ensure it's defined correctly
        // For instance:
        $assignedMenus = DB::table('menus')->get(); // Example of retrieving menu data

        return view('emiten', compact('assignedMenus')); // Pass the data to the view
    }

    public function getData()
    {
        $emitens = DB::select('SELECT STOCK_CODE, NAMA_PERUSAHAAN, SHARED, SEKTOR FROM EMITEN');
        return response()->json([
            'data' => array_map(function($emiten) {
                return (array) $emiten;
            }, $emitens)
        ]);
    }
}
