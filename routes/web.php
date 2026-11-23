<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('categories', CategoryController::class)->except(['show', 'create']);

Route::resource('tickets', TicketController::class)->only(['index', 'create', 'store', 'show']);
Route::post('tickets/{ticket}/replies', [TicketReplyController::class, 'store'])
    ->name('tickets.replies.store');

// SEMENTARA: login darurat untuk pengujian. HAPUS di Tahap 4.
Route::get('/dev-login/{user}', function (User $user) {
    abort_unless(app()->isLocal(), 404);
    Auth::login($user);

    return redirect()->route('dashboard');
});