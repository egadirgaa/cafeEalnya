<?php

namespace App\Http\Controllers\Customer;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    public function index()
    {
        $riwayat = Transaksi::with('pesanans')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.mutasi.index', compact('riwayat'));
    }

    public function bayar(Request $request, $id)
    {
        $request->validate([
            'metode' => 'required'
        ]);

        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaksi->update([
            'status' => 'Sukses'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran via ' . $request->metode . ' berhasil diproses!',
        ]);
    }

    public function updateQty(Request $request, $id)
    {
        $keranjang = session('keranjang', []);
        if (!isset($keranjang[$id])) return response()->json(['success' => false]);

        if ($request->type == 'plus') {
            // Cek stok menu di DB jika perlu
            $keranjang[$id]['qty']++;
        } else {
            if ($keranjang[$id]['qty'] > 1) {
                $keranjang[$id]['qty']--;
            }
        }

        $keranjang[$id]['subtotal'] = $keranjang[$id]['qty'] * $keranjang[$id]['harga'];
        session(['keranjang' => $keranjang]);

        return response()->json([
            'success' => true,
            'item_qty' => $keranjang[$id]['qty'],
            'item_subtotal' => $keranjang[$id]['subtotal'],
            'grand_total' => array_sum(array_column($keranjang, 'subtotal')),
            'total_qty' => array_sum(array_column($keranjang, 'qty'))
        ]);
    }

    public function hapusAjax($id)
    {
        $keranjang = session('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session(['keranjang' => $keranjang]);
        }

        return response()->json([
            'success' => true,
            'grand_total' => array_sum(array_column($keranjang, 'subtotal')),
            'total_qty' => array_sum(array_column($keranjang, 'qty'))
        ]);
    }
}
