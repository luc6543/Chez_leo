<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/tables', \App\Livewire\TablePage::class)->middleware('role:medewerker|admin');
Route::get('/reservations', \App\Livewire\ReservationPage::class)->middleware('role:medewerker|admin');
Route::get('/menu', \App\Livewire\MenuPage::class);

Route::get('/over-ons', \App\Livewire\OverOnsPage::class);
Route::get('/recensies', \App\Livewire\RecentiesPage::class);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/reservations', \App\Livewire\ReservationPage::class)->middleware('role:medewerker');
    Route::get('/admin/users', \App\Livewire\UsersPage::class)->middleware('role:admin');
    Route::get('/profile', \App\Livewire\ProfilePage::class);
    Route::get('admin/order', \App\Livewire\OrderPage::class)->middleware('role:medewerker');
    Route::get('admin/reservation/{reservation}', \App\Livewire\TableOrderPage::class)->middleware('role:medewerker');
    Route::get('/recenties/toevoegen', \App\Livewire\RecentiesToevoegPage::class);
    Route::get('/bill/{bill}',\App\Livewire\BillDetailPage::class);
    Route::get("/admin/recensies",\App\Livewire\AdminRecenties::class)->middleware('role:admin');
});