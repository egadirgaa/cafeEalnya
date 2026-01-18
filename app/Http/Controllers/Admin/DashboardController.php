<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tglHariIni = Carbon::today()->toDateString();

        $totalMenu = Menu::count();
        $totalTransaksiTotal = Transaksi::count();
        
        $pendapatanHariIni = Transaksi::where('tanggal', $tglHariIni)
                                      ->whereIn('status', ['selesai', 'Selesai', 'SELESAI', 'Sukses'])
                                      ->sum('total_harga');

        $transaksiHariIni = Transaksi::with('user')
                                    ->where('tanggal', $tglHariIni)
                                    ->latest()
                                    ->get();

        $menus = Menu::all();

        return view('admin.dashboard', compact(
            'totalMenu',
            'totalTransaksiTotal',
            'pendapatanHariIni',
            'transaksiHariIni',
            'menus'
        ));
    }
}