<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['name' => 'whyzotee']);
});


Route::get('/meet', function () {
    return view('meet.index');
})->name("meet");

Route::get('/today', function () {
    return view('meet.today');
})->name("today");

Route::get('/calendar', function () {
    return view('meet.calendar');
})->name("calendar");

Route::get('/login', function () {
    $discordOauth = "https://discord.com/oauth2/authorize?client_id=1386994038414118984&response_type=code&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Fauth%2Fdiscord%2Fcallback&scope=identify";
    return redirect($discordOauth);
});
