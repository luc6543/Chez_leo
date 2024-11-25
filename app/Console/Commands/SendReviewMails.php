<?php

namespace App\Console\Commands;

use App\Mail\MailTemplate;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReviewMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-review-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends a "Leave a review" email 3 hours after reservation time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservations = Reservation::where('active', 1)
        ->where('email_send', 0)
        ->where('end_time', '<', now()->subHours(3))
        ->get();
        $linkString = '<a href="'.env('APP_URL').'/recensies/toevoegen'.'"> Leave a review </a>';

        foreach($reservations as $reservation) {
            Mail::To($reservation->user->email)->send(new MailTemplate('Chez Leo: Laat een review achter.','Laat ons weten wat je ervan vond!',"Wat vond je van je recente bezoek van chez leo? ".$linkString));
            $reservation->email_send = 1;
            $reservation->save();
        }
    }
}
