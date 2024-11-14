<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class);

Route::group(['middleware' => ['auth']], function () {

});
