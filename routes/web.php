<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/over-ons', \App\Livewire\OverOnsPage::class);
Route::get('/menu', \App\Livewire\MenuPage::class);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/users', \App\Livewire\UsersPage::class)->middleware('role:admin');
});
