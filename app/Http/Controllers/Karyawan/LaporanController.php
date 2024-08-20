<?php

namespace App\Http\Controllers;

use App\Models\Pembatalan;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public  function laporan()
    {
        return view('laporan');
    }
}
