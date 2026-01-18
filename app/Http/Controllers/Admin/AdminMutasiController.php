<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminMutasiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user'])->orderBy('created_at', 'desc')->get();

        return view('admin.mutasi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'pesanans'])->findOrFail($id);
        return view('admin.mutasi.show', compact('transaksi'));
    }
}
