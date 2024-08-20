<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservasi;
use Carbon\Carbon;
use App\Http\Controllers\ReservasiController;

class DeleteExpiredOrders extends Command
{
    protected $signature = 'orders:delete-expired';
    protected $description = 'Update expired orders that have not been paid or verified within the given time frame';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Check for orders with status 0
        $expiredOrders = Reservasi::where('status', 0)
            ->where('created_at', '<', Carbon::now()->subMinutes(1))
            ->get();

        foreach ($expiredOrders as $order) {
            $order->status = 3;
            $order->save();

            // Prepare WhatsApp message
            $message = "Halo " . $order->nama . ", reservasi Anda dengan kode " . $order->kode . " telah dibatalkan secara otomatis karena waktu pembayaran telah habis. Silakan melakukan reservasi ulang.";
            
            // Send WhatsApp notification
            ReservasiController::sendWhatsapp($order->no_hp, $message);
        }

        // Check for orders with status 4
        $expiredVerificationOrders = Reservasi::where('status', 4)
            ->where('updated_at', '<', Carbon::now()->subMinutes(1))
            ->get();

        foreach ($expiredVerificationOrders as $order) {
            $order->status = 3;
            $order->save();

            $message = "Halo " . $order->nama . ", reservasi Anda dengan kode " . $order->kode . " telah dibatalkan secara otomatis karena waktu verifikasi telah habis. Silakan melakukan reservasi ulang.";
            
            ReservasiController::sendWhatsapp($order->no_hp, $message);
        }

        return 0;
    }
}