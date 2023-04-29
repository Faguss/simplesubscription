<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('addpost', function() {
    $response = Http::post('http://simplesubscription.test/api/post', [
        'website' => \App\Models\Website::select('title')->inRandomOrder()->first()->title,
        'title' => fake()->text(10),
        'description' => fake()->text(60),
    ]);
    return $response;
});

Route::get('addsubscriber', function() {
    $response = Http::post('http://simplesubscription.test/api/subscriber', [
        'website' => \App\Models\Website::select('title')->inRandomOrder()->first()->title,
        'email' => 'test@gmail.com'
    ]);
    return $response;
});