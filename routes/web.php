<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\ViewController as CategoryViewController;
use App\Http\Controllers\Category\DataController as CategoryDataController;
use App\Http\Controllers\Product\ViewController as ProductViewController;
use App\Http\Controllers\Product\DataController as ProductDataController;
use App\Http\Controllers\Purchase\ViewController as PurchaseViewController;
use App\Http\Controllers\Purchase\DataController as PurchaseDataController;
use App\Http\Controllers\Sale\ViewController as SaleViewController;
use App\Http\Controllers\Sale\DataController as SaleDataController;
use App\Http\Controllers\SaleHistory\ViewController as SaleHistoryViewController;
use App\Http\Controllers\SaleHistory\DataController as SaleHistoryDataController;
use App\Http\Controllers\ReportSale\ViewController as ReportSaleViewController;
use App\Http\Controllers\User\ViewController as UserViewController;
use App\Http\Controllers\User\DataController as UserDataController;




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
use App\Http\Controllers\Generate\ReceiptController;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

Route::group(['middleware' => 'auth'], function () {

	Route::get('/generate-receipt', [ReceiptController::class, 'generateReceipt'])->name('generate-receipt');

	Route::prefix('dashboard')->group(function () {
		Route::get('/', [HomeController::class, 'index'])->name('home');
		Route::get('/chart-transaction', [HomeController::class, 'chartTransaction'])->name('dashboard.chart-transaction');
		Route::get('/chart-sale', [HomeController::class, 'chartSale'])->name('dashboard.chart-sale');
	});

	Route::prefix('sale-history')->group(function () {
		Route::get('/', [SaleHistoryViewController::class, 'index'])->name('sale-history');
		Route::get('/filter', [SaleHistoryViewController::class, 'filter'])->name('sale-history.filter');

		Route::delete('/', [SalehistoryDataController::class, 'delete'])->name('sale-history.delete');
		Route::get('/{id}/edit', [SalehistoryViewController::class, 'form'])->name('sale-history.edit');


		Route::get('/{id}/product', [SalehistoryDataController::class, 'showProduct'])->name('sale-history.product');
	});

	Route::prefix('sale')->group(function () {
		Route::get('/', [SaleViewController::class, 'index'])->name('sale');
		Route::get('/filter', [SaleViewController::class, 'filter'])->name('sale.filter');
		Route::get('/receipt', [SaleViewController::class, 'receiptProduct'])->name('sale.receipt');

		Route::post('/', [SaleDataController::class, 'submit'])->name('sale.submit');
		Route::post('/create', [SaleDataController::class, 'submitProduct'])->name('sale.submit-product');
		Route::delete('/cancel', [SaleDataController::class, 'cancel'])->name('sale.cancel');
		Route::delete('/delete-cart-product', [SaleDataController::class, 'deleteCartProduct'])->name('sale.delete-cart-product');
	});



	Route::middleware('role:admin')->group(function () {
		Route::prefix('report-sale')->group(function () {
			Route::get('/', [ReportSaleViewController::class, 'index'])->name('report-sale');
			Route::get('/filter', [ReportSaleViewController::class, 'filter'])->name('report-sale.filter');
			Route::get('/export-excel', [ReportSaleViewController::class, 'exportExcel'])->name('report-sale.export-excel');
		});

		Route::prefix('purchase')->group(function () {
			Route::get('/', [PurchaseViewController::class, 'index'])->name('purchase');
			Route::get('/filter', [PurchaseViewController::class, 'filter'])->name('purchase.filter');
			Route::delete('/', [PurchaseDataController::class, 'delete'])->name('purchase.delete');


			Route::get('/create', [PurchaseViewController::class, 'form'])->name('purchase.create');
			Route::get('/{id}/edit', [PurchaseViewController::class, 'form'])->name('purchase.edit');

			Route::post('/create', [PurchaseDataController::class, 'submit']);
			Route::post('/{id}/edit', [PurchaseDataController::class, 'submit']);


			Route::get('/{id}/product', [PurchaseDataController::class, 'showProduct'])->name('purchase.product');
		});

		Route::prefix('user')->group(function () {
			Route::get('/', [UserViewController::class, 'index'])->name('user');
			Route::get('/filter', [UserViewController::class, 'filter'])->name('user.filter');
			Route::get('/create', [UserViewController::class, 'form'])->name('user.create');
			Route::get('/{id}/edit', [UserViewController::class, 'form'])->name('user.edit');
			Route::post('/', [UserDataController::class, 'submit'])->name('user.submit');

			Route::post('/create', [UserDataController::class, 'submit']);
			Route::post('/{id}/edit', [UserDataController::class, 'submit']);

			Route::get('/{id}/show', [UserDataController::class, 'show'])->name('user.show');
			Route::delete('/', [UserDataController::class, 'delete'])->name('user.delete');
		});

		Route::prefix('product')->group(function () {
			Route::get('/', [ProductViewController::class, 'index'])->name('product');
			Route::get('/filter', [ProductViewController::class, 'filter'])->name('product.filter');
			Route::get('/check-stock', [ProductViewController::class, 'checkStock'])->name('product.check-stock');

			Route::get('/{id}/show', [ProductDataController::class, 'show'])->name('product.show');
			Route::delete('/', [ProductDataController::class, 'delete'])->name('product.delete');

			Route::get('/create', [ProductViewController::class, 'form'])->name('product.create');
			Route::get('/{id}/edit', [ProductViewController::class, 'form'])->name('product.edit');

			Route::post('/create', [ProductDataController::class, 'submit'])->name('product.create-submit');
			Route::post('/{id}/edit', [ProductDataController::class, 'submit'])->name('product.edit-submit');
		});

		Route::prefix('category')->group(function () {
			Route::get('/', [CategoryViewController::class, 'index'])->name('category');
			Route::get('/filter', [CategoryViewController::class, 'filter'])->name('category.filter');
			Route::post('/', [CategoryDataController::class, 'submit'])->name('category.submit');
			Route::get('/{id}/show', [CategoryDataController::class, 'show'])->name('category.show');
			Route::delete('/', [CategoryDataController::class, 'delete'])->name('category.delete');
		});
	});

	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
