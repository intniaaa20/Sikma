<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class DeleteOldDoneOrders extends Command
{
    protected $signature = 'orders:delete-old-done';
    protected $description = 'Hapus order dengan status done yang sudah lebih dari 1 hari';

    public function handle()
    {
        $count = Order::where('status', 'done')
            ->where('updated_at', '<', Carbon::now()->subDay())
            ->delete();
        $this->info("$count order done lebih dari 1 hari telah dihapus.");
    }
}
