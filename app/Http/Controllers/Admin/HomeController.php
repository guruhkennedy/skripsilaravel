<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua tasks dengan status 1
        $tasks = Reservasi::where('status', 1)->get();

        // Total reservasi hari ini dengan status 1
        $totalReservasiHariIni = Reservasi::where('status', 1)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        // Pendapatan bulan ini dengan status 1
        $pendapatanBulanIni = Reservasi::where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->sum('total'); // Sesuaikan dengan kolom harga di tabel reservasi

        // Total reservasi bulan ini dengan status 1
        $totalReservasiBulanIni = Reservasi::where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->count();

        return view('admin.home', compact('tasks', 'totalReservasiHariIni', 'pendapatanBulanIni', 'totalReservasiBulanIni'));
    }
}