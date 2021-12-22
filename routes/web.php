<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\frontend\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('index')->name('home');
});
Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/',[AdminController::class,'index'])->name('admin');
    Route::get('/test',[AdminController::class,'test']);


});
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('admin')->group(function(){
    Route::get('/admin',[AdminController::class,'admin'])->name('admin');

});
Route::get('/admin/login',[AdminController::class,'shoLoginForm'])->name('admin.login');

Route::post('/admin/login',[AdminController::class,'login'])->name('admin.login');

Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');

//View Shop Page
Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');

Route::get('/shop',[App\Http\Controllers\frontend\HomeController::class,'shop'])->name('shop');
Route::get('/cart',[App\Http\Controllers\frontend\HomeController::class,'cart'])->name('cart');
Route::get('/contact',[App\Http\Controllers\frontend\HomeController::class,'contact'])->name('contact');
Route::get('/checkout',[App\Http\Controllers\frontend\HomeController::class,'checkout'])->name('checkout');
Route::get('/about-us',[App\Http\Controllers\frontend\HomeController::class,'about'])->name('about');
Route::get('/detail',[App\Http\Controllers\frontend\HomeController::class,'detail'])->name('detail');


//Brand Controller
Route::get('/brand-all',[App\Http\Controllers\backend\BrandController::class,'allBrand'])->name('allBrand');
Route::post('/add-brand',[App\Http\Controllers\backend\BrandController::class,'storeBrand'])->name('storeBrand');
Route::get('/delete-brand/{id}',[App\Http\Controllers\backend\BrandController::class,'deleteBrand'])->name('deleteBrand');
Route::get('/edit-brand/{id}',[App\Http\Controllers\backend\BrandController::class,'editBrand'])->name('editBrand');
Route::post('/update-brand/{id}',[App\Http\Controllers\backend\BrandController::class,'updateBrand'])->name('updateBrand');









