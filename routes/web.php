<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Analytics\Dashboard;
use App\Livewire\Graduates\Graduated;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', Dashboard::class)->name('dashboard');
});


require __DIR__.'/graduates.php';
require __DIR__.'/settings.php';
