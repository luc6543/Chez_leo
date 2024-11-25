<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservationsObserver
{
    /**
     * Handle the Reservation "created" event.
     */
    public function created(Reservation $reservation): void
    {
        if ($reservation->user != null) {
            $reservation->bill()->create([
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user->id
            ]);
        } else {
            $reservation->bill()->create([
                'reservation_id' => $reservation->id,
            ]);
        }
    }

    /**
     * Handle the Reservation "updated" event.
     */
    public function updated(Reservation $reservation): void
    {
        //
    }

    /**
     * Handle the Reservation "deleted" event.
     */
    public function deleted(Reservation $reservation): void
    {
        //
    }

    /**
     * Handle the Reservation "restored" event.
     */
    public function restored(Reservation $reservation): void
    {
        //
    }

    /**
     * Handle the Reservation "force deleted" event.
     */
    public function forceDeleted(Reservation $reservation): void
    {
        //
    }
}
