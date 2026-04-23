<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Import\DataManager;
use App\Livewire\Analytics\Dashboard;
use App\Livewire\Graduates\ListGraduate;
use App\Livewire\Graduates\CreateGraduate;

Route::livewire('/list-graduate', ListGraduate::class)->name('graduate.list-graduate');
Route::livewire('/create-graduate', CreateGraduate::class)->name('graduate.create-graduate');
Route::livewire('/report-analytics', Dashboard::class)->name('graduate.report-analytics');
Route::livewire('/data-manager', DataManager::class)->name('graduate.data-manager');