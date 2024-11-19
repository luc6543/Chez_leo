<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;

class RemoveInactiveReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-inactive-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes inactive reservations when its inactive for longer than 24 hours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Reservation::where('active', 0) // Assuming 'inactive' is the status column
        ->where('created_at', '<', now()->subDay()) // Subtract 1 day (24 hours) from the current time
        ->delete();
    }
}
