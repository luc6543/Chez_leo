<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Bescherm de velden die massaal ingevuld kunnen worden (preventie tegen mass-assignment)
    protected $fillable = [
        'user_id',  // Gebruiker die de review heeft geplaatst
        'review',   // De review tekst
        'rating',   // De rating (bijv. 1 tot 5)
        'is_homepage_approved', // Goedgekeurd voor de homepage
        'is_approved', // Goedgekeurd of niet
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Veronderstelt dat de User model bestaat en geconfigureerd is.
    }
}