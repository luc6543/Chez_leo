<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/over-ons', \App\Livewire\OverOnsPage::class);
Route::get('/recenties', \App\Livewire\RecentiesPage::class);
Route::get('/recentieToevoegen', \App\Livewire\RecentiesToevoegPage::class);
Route::group(['middleware' => ['auth']], function () {

});