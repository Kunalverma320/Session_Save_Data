<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockerController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index'])->name('home');
Route::post('/formdata',[HomeController::class,'formdata'])->name('form.data');
Route::get('/formdata_edit/{id}',[HomeController::class,'formdata_edit'])->name('form.data.edit');
Route::post('/formdata_edit_save/{id}',[HomeController::class,'formdata_edit_save'])->name('form.data.edit.save');
Route::get('/formdata_delete/{id}',[HomeController::class,'formdata_delete'])->name('form.data.delete');
Route::get('/finalsubmit',[HomeController::class,'finalsubmit'])->name('final.submit');
Route::post('/csvupload',[HomeController::class,'csvupload'])->name('csv.upload');


//locker
Route::get('/lock',[LockerController::class,'index'])->name('lock');
Route::get('/lockers', [LockerController::class, 'fetchLockers'])->name('lockers.fetch');
Route::post('/data/store', [LockerController::class, 'store'])->name('data.store');
Route::post('/userdata/fatch', [LockerController::class, 'userdatafatch'])->name('userdata.fatch');
Route::post('/userdata/defuse', [LockerController::class, 'defuseKey'])->name('userdata.defuse');





