<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::livewire('/graduates', 'graduates::graduate.index')->name('graduates.index'); 
    Route::livewire('/graduates/create', 'graduates::graduate.create')->name('graduates.create');
    Route::livewire('/graduates/academic-manager', 'graduates::graduate.academic-manager')->name('graduates.academic-manager');

});


// require __DIR__.'/graduates.php';
require __DIR__.'/settings.php';
