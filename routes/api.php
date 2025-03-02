<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/index',[StudentController::class,'index'] ); 

// Route::post('/store',[StudentController::class,'store'] );
// Route::get('/show/{id}',[StudentController::class,'show'] );
// Route::put('/update/{id}',[StudentController::class,'update'] );
// //Route::put('/update/{student}',[StudentController::class,'update'] );
// Route::delete('/delete/{id}',[StudentController::class,'delete'] );



Route::get('/allnews', [NewsController::class, 'fetchNews']);