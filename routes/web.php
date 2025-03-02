<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AfrikpayController;
use App\Http\Controllers\ContactIndexController;
use App\Http\Controllers\DocumentProtectionController;
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
Route::get('/piece-intro', [TheFindController::class, 'intro'])->name('find.intro');
Route::get('/piece-enregistrer', [TheFindController::class, 'index'])->name('find.register');
Route::post('/piece/enregistrer', [TheFindController::class, 'store'])->name('find.store');
Route::post('/piece-enregistrer-find', [TheFindController::class, 'store'])->name('find.store.explicit');
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
    Route::get('/payment-finder', [AdminController::class, 'allFind'])->name('admin.allFind');
    Route::get('/all-find', [AdminController::class, 'finderPayment'])->name('admin.payment.finder');
    // Nouvelles routes pour la gestion des pièces
    Route::get('/find/{id}', [AdminController::class, 'show'])->name('admin.find.show');
    Route::get('/find/{id}/edit', [AdminController::class, 'edit'])->name('admin.find.edit');
    Route::put('/find/{id}', [AdminController::class, 'update'])->name('admin.find.update');
    Route::delete('/find/{id}', [AdminController::class, 'destroy'])->name('admin.find.destroy');
    Route::resource('faq', \App\Http\Controllers\Admin\FaqsController::class);
    Route::resource('piece', \App\Http\Controllers\Admin\PieceController::class);
});

Route::middleware(['auth', 'verified'])->group(function (){
    //Paiment paypal
    Route::post('/payment/{id}', [PaypalController::class, 'store'])->name('paypal.store');
    //Paiement Afrikpay
    Route::post('/paiement-afrikpay', [AfrikpayController::class, 'store'])->name('afrikpay.store');
});

Route::post('/generate-token', [AfrikpayController::class, 'generateToken'])->name('afrikpay.token');

Route::get('/payment-afrikpay/{id}', [AfrikpayController::class, 'index'])->name('afrikpay.index');

// Routes pour la protection des documents
Route::middleware(['auth'])->group(function () {
    Route::get('/documents/protect', [DocumentProtectionController::class, 'index'])->name('documents.protect');
    Route::post('/documents/protect', [DocumentProtectionController::class, 'protect']);
    Route::get('/documents/{document}/download', [DocumentProtectionController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentProtectionController::class, 'destroy'])->name('documents.destroy');
});

require __DIR__.'/auth.php';