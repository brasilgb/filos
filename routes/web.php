<?php

use App\Http\Controllers\TagPageController;
use App\Livewire\PrintTag;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/printer-tag', [TagPageController::class, 'printTags'])->name('printer-register');
Route::get('/printer-tag', PrintTag::class)->name('printer-register');
