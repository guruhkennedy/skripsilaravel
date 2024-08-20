<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\BuktiPembayaran;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Site;
use App\Http\Controllers\Karyawan\ReservasiController as WaController;
use PDF;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservasis = Reservasi::when($request->input('name'), function ($query, $name) {
            return $query->where('kode', 'like', '%' . $name . '%');
        })->when($request->input('status'), function ($query, $name) {
            return $query->where('status', $name);
        })
            ->select('*')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        foreach ($reservasis as $reservasi) {
            $reservasi->bukti_pembayaran = BuktiPembayaran::where('id_reservasi', $reservasi->id)->first();
            $reservasi->bukti_pembayaran = $reservasi->bukti_pembayaran ? $reservasi->bukti_pembayaran->gambar : null;
        }
        return view('karyawan.reservasi.index', compact('reservasis'));
    }


        public function laporan() //fungsi laporan
    {
        
     return view ('karyawan/laporan');

    }

    public function cetaklaporan($tglawal, $tglakhir)
{
    $cetaklaporan = Reservasi::whereBetween('created_at', [
            \Carbon\Carbon::parse($tglawal)->startOfDay(),
            \Carbon\Carbon::parse($tglakhir)->endOfDay(),
        ])
        ->where('status', 1)
        ->orderBy('id')
        ->get();
        $bulanawal =  \Carbon\Carbon::parse($tglawal)->locale('id')->isoFormat('D MMMM YYYY');
        $bulanakhir =  \Carbon\Carbon::parse($tglakhir)->locale('id')->isoFormat('D MMMM YYYY');
        $currentUrl = request()->fullUrl();
    $totalSum = $cetaklaporan->sum('total');

    // Generate PDF
    $pdf = PDF::loadView('karyawan/cetak', compact('cetaklaporan', 'totalSum', 'bulanawal', 'bulanakhir', 'currentUrl'))
    ->setPaper('a4', 'landscape');

    // Download the PDF with a custom filename
    return $pdf->download('LaporanPenghasilan.pdf');
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservasi $reservasi)
    {
        $reservasi->delete();
        return redirect()->route('karyawan.reservasi.index')->with('success', 'Reservasi berhasil dihapus');
    }
    
    public function cetak_invoice(Request $request)
    {
        $id = $request->kode;
        $transaction = Reservasi::select('reservasi.*', 'gedung.nama as product_name', 'gedung.harga as product_price')
            ->where('reservasi.kode', $id)
            ->join('gedung', 'gedung.id', '=', 'reservasi.id_gedung')
            ->first();
        $site = Site::first(); // Pastikan Anda memiliki model Site
        $pdf = PDF::loadview('invoice', ['transaksi' => $transaction, 'site' => $site])
            ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }


    public function proses(Reservasi $reservasi)
    {
        $reservasi->update([
            'status' => 1
        ]);
        $pesan = "Pembayaran atas nama {{NAMA}} dengan kode {{KODE}} telah berhasil diverifikasi. \n\n Reservasi anda berhasil diterima \n\n Silahkan isi google form berikut untuk survei kepuasan sistem kami \n\n https://forms.gle/eQBBACwxnKHETLHu7";
        $pesan = str_replace('{{NAMA}}', $reservasi->nama, $pesan);
        $pesan = str_replace('{{KODE}}', $reservasi->kode, $pesan);
        $pesan = str_replace('{{LINK}}', url('order?kode=' . $reservasi->kode), $pesan);
        $this->sendWhatsapp($reservasi->no_hp, $pesan);
        return redirect()->route('karyawan.reservasi.index')->with('success', 'Reservasi berhasil diperbarui');
    }

    public function proses_upload_ulang(Reservasi $reservasi)
    {
        $pesan = "Bukti pembayaran dengan kode {{KODE}} atas nama {{NAMA}} ditolak, \n\n alasan : bukti upload tidak jelas atau tidak valid \n\n silahkan upload ulang bukti ke nomor whatsapp ini, terima kasih";
        $pesan = str_replace('{{KODE}}', $reservasi->kode, $pesan);
        $pesan = str_replace('{{LINK}}', url('order?kode=' . $reservasi->kode), $pesan);
        $pesan = str_replace('{{NAMA}}', $reservasi->nama, $pesan);
        $this->sendWhatsapp($reservasi->no_hp, $pesan);
        return redirect()->route('karyawan.reservasi.index')->with('success', 'Sukses mengirim notifikasi ke pelanggan');
    }

    public static function sendWhatsapp($no_tujuan, $pesan)
    {
        $data = [
            'token' => '55R7dQWtr3FZGBF1@Dui', // Ganti dengan API token Anda dari Fonnte
            'target' => $no_tujuan,
            'message' => $pesan
        ];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $data['token'] 
            ),
        ));
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return 'Error: ' . $error_msg;
        }
    
        curl_close($curl);
    
        return $response;
    }
}

