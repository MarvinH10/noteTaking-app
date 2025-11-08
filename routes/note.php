<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteBookController;

Route::get('/notebooks/active', [NoteBookController::class, 'index'])->name('notebook.index');
