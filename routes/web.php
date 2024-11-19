<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/tables', \App\Livewire\TablePage::class)->middleware('role:medewerker|admin');
Route::get('/reservations', \App\Livewire\ReservationPage::class)->middleware('role:medewerker|admin');
Route::get('/menu', \App\Livewire\MenuPage::class);

Route::get('/over-ons', \App\Livewire\OverOnsPage::class);
Route::get('/recenties', \App\Livewire\RecentiesPage::class);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/reservations', \App\Livewire\ReservationPage::class)->middleware('role:medewerker');
    Route::get('/admin/users', \App\Livewire\UsersPage::class)->middleware('role:admin');
    Route::get('/profile', \App\Livewire\ProfilePage::class);
    Route::get('/recenties/toevoegen', \App\Livewire\RecentiesToevoegPage::class);
});
