<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/over-ons', \App\Livewire\OverOnsPage::class);
Route::get('/menu', \App\Livewire\MenuPage::class);

Route::group(['middleware' => ['auth']], function () {

});
