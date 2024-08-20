<?php

namespace App\Http\Controllers;

use App\Models\Pembatalan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Karyawan\ReservasiController as WaController; // Pastikan WaController diimport

class PembatalanController extends Controller
{
    public  function index()
    {
        return view('pembatalan');
    }

    public function pembatalan(Request $request)
    {
        $this->validate(
            $request,
            [
                'kode' => 'required',
                'no_hp' => 'required|exists:reservasi,no_hp',
                'alasan' => 'required',
            ],
            [
                'kode.required' => 'Kode reservasi tidak boleh kosong',
                'no_hp.required' => 'Nomor handphone tidak boleh kosong',
                'no_hp.exists' => 'Nomor handphone tidak sama dengan nomor handphone yang terdaftar pada bookingan ini',
                'alasan.required' => 'Alasan pembatalan tidak boleh kosong',
            ]
        );

        $reservasi = Reservasi::where('kode', $request->kode)->first();

        if (!$reservasi) {
            return redirect()->back()->with('error', 'Kode reservasi tidak ditemukan');
        }

        if ($reservasi->status == 3) {
            return redirect()->back()->with('error', 'Reservasi ini sudah dibatalkan');
        }

        $pembatalan = Pembatalan::where('id_reservasi', $reservasi->id)->first();

        if ($pembatalan) {
            return redirect()->back()->with('error', 'Reservasi ini sudah diajukan pembatalan sebelumnya. Silahkan tunggu admin merespon');
        }

        Pembatalan::create([
            'id_reservasi' => $reservasi->id,
            'alasan' => $request->alasan,
            'status' => 0,
        ]);

        // Pesan untuk pelanggan
        $pesan = "[Pengelola] Ada Pengajuan Pembatalan reservasi dengan kode {{KODE}} Atas Nama: {{NAMA}}.  \n\n Silahkan cek pada menu pembatalan.";
        $pesan = str_replace('{{KODE}}', $reservasi->kode, $pesan);
        $pesan = str_replace('{{NAMA}}', $reservasi->nama, $pesan);
        $pesan = str_replace('{{ALASAN}}', $request->alasan, $pesan);

        WaController::sendWhatsapp('082112529951', $pesan);

        return redirect()->route('pembatalan-user')->with('success', 'Berhasil, silahkan tunggu pemberitahuan selanjutnya ke nomor WhatsApp anda');
    }
}