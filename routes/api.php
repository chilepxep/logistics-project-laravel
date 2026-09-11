<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Supplier;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/suppliers-by-country/{country_id}', function($country_id) {
    return \App\Models\Supplier::where('country_id', $country_id)->get(['id', 'ten_ncc', 'thanh_pho']);
});