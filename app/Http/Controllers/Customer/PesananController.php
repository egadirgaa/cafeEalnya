<?php

namespace App\Http\Controllers\Customer;

use App\Models\Menu;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PesananController extends Controller
{
    public function index()
    {
        $keranjang = session('keranjang', []);
        $total = 0;

        foreach ($keranjang as $row) {
            $total += (int)$row['subtotal'];
        }

        return view('customer.pesanan.index', compact('keranjang', 'total'));
    }

    public function tambah(Request $request, $id)
    {
        $qty = max(1, (int) $request->input('qty', 1));

        DB::transaction(function () use ($id, $qty) {
            $menu = Menu::lockForUpdate()->findOrFail($id);

            if ((int)$menu->stok < $qty) {
                abort(400, 'Stok tidak cukup');
            }

            $menu->decrement('stok', $qty);

            $keranjang = session('keranjang', []);

            if (!isset($keranjang[$id])) {
                $keranjang[$id] = [
                    'id' => $menu->id,
                    'nama' => $menu->nama_menu ?? $menu->nama,
                    'harga' => (int) $menu->harga,
                    'qty' => 0,
                    'subtotal' => 0,
                ];
            }

            $keranjang[$id]['qty'] += $qty;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['qty'] * $keranjang[$id]['harga'];

            session(['keranjang' => $keranjang]);
        });

        if ($request->ajax()) {
        $keranjang = session('keranjang', []);
        $totalQty = array_sum(array_column($keranjang, 'qty'));
        return response()->json([
            'success' => true,
            'total_qty' => $totalQty,
            'message' => 'Pesanan masuk keranjang!',
            'cart_count' => count(session('keranjang', []))
        ]);
    }

    return back()->with('success', 'Pesanan masuk keranjang!');
    }

    public function hapus($id)
    {
        DB::transaction(function () use ($id) {
            $keranjang = session('keranjang', []);
            if (!isset($keranjang[$id])) return;

            $qty = (int) $keranjang[$id]['qty'];

            $menu = Menu::lockForUpdate()->find($id);
            if ($menu) {
                $menu->increment('stok', $qty);
            }

            unset($keranjang[$id]);
            session(['keranjang' => $keranjang]);
        });

        return back()->with('success', 'Item dihapus.');
    }

    public function clear()
    {
        DB::transaction(function () {
            $keranjang = session('keranjang', []);

            foreach ($keranjang as $row) {
                $id = $row['id'];
                $qty = (int) $row['qty'];

                $menu = Menu::lockForUpdate()->find($id);
                if ($menu) {
                    $menu->increment('stok', $qty);
                }
            }

            session()->forget('keranjang');
        });

        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout()
    {
        $keranjang = session('keranjang', []);
        
        if (empty($keranjang)) {
            return redirect()->route('customer.pesanan.menu')->with('error', 'Keranjang Anda masih kosong.');
        }

        $total = 0;
        foreach ($keranjang as $row) {
            $total += (int)$row['subtotal'];
        }

        return view('customer.pesanan.checkout', compact('keranjang', 'total'));
    }

    public function prosesCheckout(Request $request)
    {
        $keranjang = session()->get('keranjang');

        if (!$keranjang || count($keranjang) == 0) {
            return redirect()->route('customer.pesanan.menu')->with('error', 'Keranjang kosong!');
        }

        try {
            DB::beginTransaction();

            if (!Auth::check()) {
                $request->validate([
                    'name' => 'required|string|max:255',
                ], [
                    'name.required' => 'Nama wajib diisi untuk memesan.'
                ]);

                $user = User::create([
                    'name' => $request->name,
                ]);

                Auth::login($user);
            }

            $user = Auth::user();

            $totalHarga = array_sum(array_column($keranjang, 'subtotal'));

            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'total_harga' => $totalHarga,
                'status' => 'Sukses',
                'tanggal' => now(),
            ]);

            foreach ($keranjang as $item) {
                Pesanan::create([
                    'transaksi_id' => $transaksi->id,
                    'nama_menu'    => $item['nama'],
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga'],
                    'total'        => $item['subtotal'],
                ]);
            }

            DB::commit();

            session()->forget('keranjang');

            return redirect()->route('customer.pesanan.menu')
                            ->with('success', 'Pesanan berhasil dikirim! Silakan tunggu pesanan Anda, ' . $user->name);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
