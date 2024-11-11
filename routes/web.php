<?php


use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BukusController;
use App\Http\Controllers\JenisUsersController;
use App\Http\Controllers\KategorisController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostingsController;
use App\Http\Controllers\EmitenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/coba', function () {
    return view('coba.coba');
});

Route::get('/dashboard', function () {
    return view('halaman.dashboard');
});
Route::get('/c', function () {
    return view('layout.main');
});
Route::get('/infogempa', function () {
    return view('infogempa');
});

//Auth
Route::get('/register', [UserController::class, 'registerview']);
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/', [UserController::class, 'loginview']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Mahasiswa Routes
    Route::middleware('Mahasiswa')->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index']);
    });

    // Admin Routes
    Route::middleware('Admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index']);

        // User management
        Route::get('/admin/user', [AdminController::class, 'list']);
        Route::post('/admin/user/add', [AdminController::class, 'store'])->name('store.users');
        Route::get('/admin/user/{id}/edit', [AdminController::class, 'edit'])->name('edit.users');
        Route::put('/admin/user/{id}', [AdminController::class, 'update'])->name('update.users');
        Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('delete.users');

        // Role management
        Route::get('/admin/role', [JenisUsersController::class, 'index']);
        Route::post('/admin/role/add', [JenisUsersController::class, 'store'])->name('store.role');
        Route::get('/admin/role/{id}/edit', [JenisUsersController::class, 'edit'])->name('edit.role');
        Route::put('/admin/role/{id}', [JenisUsersController::class, 'update'])->name('update.role');
        Route::delete('/admin/role/{id}', [JenisUsersController::class, 'destroy'])->name('delete.role');

        // Menu management
        Route::get('/admin/menu', [MenuController::class, 'index']);
        Route::post('/admin/menu/add', [MenuController::class, 'store'])->name('store.menu');
        Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit'])->name('edit.menu');
        Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('update.menu');
        Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('delete.menu');


    });

    Route::get('/admin/useractivity', function () {
        return view('admin.activity');
    });

    // Dosen Routes
    Route::middleware('Dosen')->group(function () {
        Route::get('/dosen/dashboard', function () {
            return view('dosen.dashboard');
        });
    });

    // Posting
    Route::get('/user/post', [PostingsController::class, 'index']);
    Route::get('/user/up', [PostingsController::class, 'add']);
    Route::post('/user/upload', [PostingsController::class, 'store'])->name('store.post');
    Route::get('/user/post/{id}/edit', [PostingsController::class, 'edit'])->name('edit.post');
    Route::put('/user/post/{id}', [PostingsController::class, 'update'])->name('update.post');
    Route::delete('/user/post/{id}', [PostingsController::class, 'destroy'])->name('delete.post');

    // Komen
    Route::post('/user/komen/add/{id}', [PostingsController::class, 'addComment'])->name('add.komen');
    Route::delete('/user/komen/{posting_id}', [PostingsController::class, 'hapuskomen'])->name('delete.komen');

    // Like
    Route::post('/user/like/{posting_id}', [PostingsController::class, 'addlike'])->name('add.like');
    Route::delete('/user/like/{posting_id}', [PostingsController::class, 'dislike'])->name('delete.like');


    Route::get('/dashboard', [UserController::class, 'general']);

    // kategori
    Route::get('/admin/kategori', [KategorisController::class, 'index']);
    Route::post('/admin/kategori/add', [KategorisController::class, 'store'])->name('store.kategori');
    Route::get('/admin/kategori/{id}/edit', [KategorisController::class, 'edit'])->name('edit.kategori');
    Route::put('/admin/kategori/{id}', [KategorisController::class, 'update'])->name('update.kategori');
    Route::delete('/admin/kategori/{id}', [KategorisController::class, 'destroy'])->name('delete.kategori');

    // buku
    Route::get('/admin/buku', [BukusController::class, 'index']);
    Route::post('/admin/buku/add', [BukusController::class, 'store'])->name('store.buku');
    Route::get('/admin/buku/{id}/edit', [BukusController::class, 'edit'])->name('edit.buku');
    Route::put('/admin/buku/{id}', [BukusController::class, 'update'])->name('update.buku');
    Route::delete('/admin/buku/{id}', [BukusController::class, 'destroy'])->name('delete.buku');

    // emiten
    Route::get('/emitens', [EmitenController::class, 'index'])->name('emitens.index');
    Route::get('/dashboard-data', function () {
        // Query to get the sum of volume, value, and frequency for each emitter
        $kpiData = DB::table('T_TRANSAKSI_HARIAN')
            ->select('STOCK_CODE',
                     DB::raw('SUM(VOLUME) as total_volume'),
                     DB::raw('SUM(VALUE) as total_value'),
                     DB::raw('SUM(FREQUENCY) as total_frequency'))
            ->whereIn('STOCK_CODE', ['BRIS', 'GOTO', 'ANTM', 'BBCA', 'BBRI'])
            ->groupBy('STOCK_CODE')
            ->get();


        $transactionSummaryData = $kpiData->map(function ($item) {
            return [
                'STOCK_CODE' => $item->STOCK_CODE,
                'volume' => $item->total_volume,
                'value' => $item->total_value,
                'frequency' => $item->total_frequency,
            ];
        });

        // Prepare data for Pie Chart (total value by emitter)
        $pieChartData = $kpiData->map(function ($item) {
            return [
                'STOCK_CODE' => $item->STOCK_CODE,
                'sum_value' => $item->total_value,
            ];
        });

        // Monthly frequency for each emitter
        $frequencyData = DB::table('T_TRANSAKSI_HARIAN')
            ->select('STOCK_CODE', DB::raw('MONTH(DATE_TRANSACTION) as month'), DB::raw('SUM(FREQUENCY) as sum_frequency'))
            ->whereIn('STOCK_CODE', ['BRIS', 'GOTO', 'ANTM', 'BBCA', 'BBRI'])
            ->groupBy('STOCK_CODE', DB::raw('MONTH(DATE_TRANSACTION)'))
            ->get();

        // Closing price data for line chart
        $lineChartData = DB::table('T_TRANSAKSI_HARIAN')
            ->select('STOCK_CODE', DB::raw('DATE(DATE_TRANSACTION) as date_transaction'), 'CLOSE')
            ->whereIn('STOCK_CODE', ['BRIS', 'GOTO', 'ANTM', 'BBCA', 'BBRI'])
            ->orderBy('date_transaction')
            ->get();


        // Response data
        return response()->json([
            'emitenCount' => $kpiData->count(),
            'totalVolume' => $kpiData->sum('total_volume'),
            'totalValue' => $kpiData->sum('total_value'),
            'totalFrequency' => $kpiData->sum('total_frequency'),
            'transactionSummaryData' => $transactionSummaryData,
            'pieChartData' => $pieChartData,
            'frequencyData' => $frequencyData,
            'lineChartData' => $lineChartData,
        ]);
    });

    Route::get('/saham', function () {
    return view('saham');
});



});

