<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return view('meet.index');
    }

    return view('welcome');
});

Route::get('/today', function () {
    return view('meet.today');
})->name("today")->middleware('auth');

Route::get('/calendar', function () {
    return view('meet.calendar');
})->name("calendar")->middleware('auth');

Route::get('/login', function () {
    $discordOauth = "https://discord.com/oauth2/authorize?client_id=1386994038414118984&response_type=code&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fauth%2Fdiscord%2Fcallback&scope=identify";
    return redirect($discordOauth);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');


Route::get('/auth/discord/callback', [LoginController::class, 'discordAuth']);
