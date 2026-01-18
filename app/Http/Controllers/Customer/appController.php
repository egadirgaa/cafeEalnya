<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class appController extends Controller
{
    public function index()
    {
        $menus = Menu::query()->orderBy('id', 'desc')->get();

        $menus = $menus->reject(function ($m) {
            $nama = strtolower(trim($m->nama_menu ?? $m->nama ?? ''));
            $harga = (int) ($m->harga ?? 0);

            return ($nama === 'machalatte' && $harga === 34)
                || ($nama === 'tiramisu sunday' && $harga === 35);
        });

        $menus = $menus
            ->groupBy(fn($m) => strtolower(trim($m->nama_menu ?? $m->nama ?? '')))
            ->map(fn($group) => $group->sortByDesc(fn($m) => (int)($m->harga ?? 0))->first())
            ->values();

        return view('customer.menu.index', compact('menus'));
    }
}
