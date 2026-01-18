<?php

namespace App\Http\Controllers\halamanDepan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // admin
    public function index()
    {
        $menus = Menu::All();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'gambar'    => 'required|image|max:2048'
        ]);

        $path = $request->file('gambar')->store('menu', 'public');

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'gambar'    => basename($path),
            'user_id'   => auth()->id(),
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'gambar'    => 'nullable|image|max:2048',
        ]);

        $menu->nama_menu = $request->nama_menu;
        $menu->kategori = $request->kategori;
        $menu->harga = $request->harga;
        $menu->stok = $request->stok;

        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                $oldPath = str_contains($menu->gambar, 'menu/') ? $menu->gambar : 'menu/' . $menu->gambar;

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $request->file('gambar')->store('menu', 'public');
            $menu->gambar = $path;
        }

        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui! ✨');
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $namaMenu = $menu->nama_menu;
            
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }

            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => "Menu $namaMenu telah di Hapus dari koleksi! "
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus menu.'
            ], 500);
        }
    }

    // customer
    public function customerIndex()
    {
        $menus = Menu::all();
        return view('customer.menu.index', compact('menus'));
    }
}
