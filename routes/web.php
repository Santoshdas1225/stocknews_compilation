<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\NewsController;
use App\Http\Controllers\PopulationController;
use Illuminate\Support\Facades\Artisan;

////////////////////////////////////////////////////////////////////////////////

Route::any('/allnews',[NewsController::class,'alldata']);
Route::any('/home',[NewsController::class,'alldata']);

Route::any('/insertdata',[NewsController::class,'insertdata']);
Route::any('/moneycontroldashboard',[NewsController::class,'moneycontroldashboard'])->name('moneycontrolload');
Route::any('/thehindudashboard',[NewsController::class,'thehindudashboard'])->name('thehinduload');
Route::any('/livemint',[NewsController::class,'livemint'])->name('livemintload');
Route::any('/zeebusiness',[NewsController::class,'zeebusiness'])->name('zeeload');
Route::any('/CNBCTV18',[NewsController::class,'CNBCTV18'])->name('CNBCTV18load');
Route::any('/all',[NewsController::class,'all'])->name('all.load');

Route::get('posts',[NewsController::class,'alldata'])->name('posts.index');

Route::get('ystpost',[NewsController::class,'alldata'])->name('ystpost');

// Route::get('alldata', [NewsController::class, 'alldata'])->name('alldata');

Route::any('/contactus',[NewsController::class,'contactus']);
Route::any('/privacypolicy',[NewsController::class,'privacypolicy']);

