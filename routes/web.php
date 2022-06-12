<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ContactIndexController;
use App\Http\Controllers\FaqsIndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\TheFindController;
use App\Http\Controllers\TheFoundController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeController::class)->name('home');
Route::get('/piece-enregistrer', [TheFindController::class, 'index'])->name('find.register');
Route::post('/piece-enregistrer', [TheFindController::class, 'store'])->name('find.store');
Route::get('/piece-rechercher/{thefind}', [TheFindController::class, 'show'])->name('find.show');
Route::put('/piece-rechercher/{thefind}', [TheFindController::class, 'update'])->name('find.update');
Route::get('/piece-rechercher', [TheFoundController::class, 'search'])->name('found.search');
Route::get('/piece/{thefind}/enregistrer', [TheFoundController::class, 'register'])->name('found.info');
Route::post('/piece/enregistrer', [TheFoundController::class, 'store'])->name('found.store');
Route::get('/paiement', [TheFoundController::class, 'paiement'])->name('paiement');
Route::get('/contacter-nous', ContactIndexController::class)->name('contact');
Route::get('/faqs', FaqsIndexController::class)->name('faqs');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/liste-piece-trouvee', [UserController::class, 'listing'])->name('find.list');
    Route::get('/ma-piece-trouvee', [UserController::class, 'myPiece'])->name('found.item');
    Route::get('/finder-user/{user}', [UserController::class, 'show'])->name('show.finder');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/{user}/updated', [UserController::class, 'update'])->name('user.update');
    Route::put('/changed-password/{user}', [UserController::class, 'updatePassword'])->name('user.update.password');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/new-user', [AdminController::class, 'create'])->name('admin.new.user');
    Route::get('/payment', [AdminController::class, 'listingPayment'])->name('admin.payment');
    Route::get('/payment-finder', [AdminController::class, 'finderPayment'])->name('admin.payment.finder');
    Route::resource('faq', \App\Http\Controllers\Admin\FaqsController::class);
    Route::resource('piece', \App\Http\Controllers\Admin\PieceController::class);
});

//Paiment paypal
Route::middleware(['auth', 'verified'])->group(function (){
    Route::post('/payment/{id}', [PaypalController::class, 'store'])->name('paypal.store');
});

require __DIR__.'/auth.php';
