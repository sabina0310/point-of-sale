<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\ViewController as CategoryViewController;
use App\Http\Controllers\Category\DataController as CategoryDataController;
use App\Http\Controllers\Product\ViewController as ProductViewController;
use App\Http\Controllers\Product\DataController as ProductDataController;
use App\Http\Controllers\Purchase\ViewController as PurchaseViewController;
use App\Http\Controllers\Purchase\DataController as PurchaseDataController;



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

Route::get('/', function () {
	return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;


Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {

	Route::prefix('purchase')->group(function () {
		Route::get('/', [PurchaseViewController::class, 'index'])->name('purchase');
		Route::get('/create', [PurchaseViewController::class, 'form'])->name('purchase.create');
		Route::post('/create', [PurchaseDataController::class, 'submit']);

		Route::get('/{id}/product', [PurchaseDataController::class, 'showProduct'])->name('purchase.product');
	});

	Route::prefix('product')->group(function () {
		Route::get('/', [ProductViewController::class, 'index'])->name('product');
		Route::get('/{id}/show', [ProductDataController::class, 'show'])->name('product.show');
		Route::delete('/', [ProductDataController::class, 'delete'])->name('product.delete');

		Route::get('/create', [ProductViewController::class, 'form'])->name('product.create');
		Route::get('/{id}/edit', [ProductViewController::class, 'form'])->name('product.edit');

		Route::post('/create', [ProductDataController::class, 'submit']);
		Route::post('/{id}/edit', [ProductDataController::class, 'submit']);
	});

	Route::prefix('category')->group(function () {
		Route::get('/', [CategoryViewController::class, 'index'])->name('category');
		Route::post('/', [CategoryDataController::class, 'submit'])->name('category.submit');
		Route::get('/{id}/show', [CategoryDataController::class, 'show'])->name('category.show');
		Route::delete('/', [CategoryDataController::class, 'delete'])->name('category.delete');
	});

	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');


	// Route::group(['prefix' => 'category'], function () {
	// 	Route::get('/', [CategoryViewController::class, 'index'])->name('category');
	// });
});
