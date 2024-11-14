<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/menu', \App\Livewire\MenuPage::class);

Route::group(['middleware' => ['auth']], function () {

});
