<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AfrikpayController;
use App\Http\Controllers\ContactIndexController;
use App\Http\Controllers\DocumentProtectionController;
use App\Http\Controllers\FaqsIndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\SubscriptionPlanController;
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
// Routes pour la page de contact
Route::get('/contacter-nous', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contacter-nous/submit', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
Route::get('/faqs', FaqsIndexController::class)->name('faqs');
Route::get('/icon-test', function() {
    return \Inertia\Inertia::render('IconTest');
})->name('icon.test');

// Routes pour les plans d'abonnement
Route::get('/abonnements', [SubscriptionPlanController::class, 'show'])->name('subscription.plans');
Route::get('/api/subscription-plans', [SubscriptionPlanController::class, 'index'])->name('subscription-plans.index');
Route::get('/api/subscription-plans/{id}', [SubscriptionPlanController::class, 'getById'])->name('subscription-plans.show');
Route::post('/api/subscription-plans/price', [SubscriptionPlanController::class, 'getPriceInCurrency'])->name('subscription-plans.price');
// Routes pour la souscription
Route::get('/subscription/confirm/{planId}', [SubscriptionPlanController::class, 'confirmSubscription'])->name('subscription.confirm');
Route::post('/subscription/process', [SubscriptionPlanController::class, 'processSubscription'])->name('subscription.process');

// Routes pour les paiements PayPal
Route::prefix('payment/paypal')->group(function () {
    Route::get('/return', [\App\Http\Controllers\PaymentControllers\PaypalController::class, 'return'])->name('paypal.return');
    Route::get('/cancel', [\App\Http\Controllers\PaymentControllers\PaypalController::class, 'cancel'])->name('paypal.cancel');
    Route::post('/webhook', [\App\Http\Controllers\PaymentControllers\PaypalController::class, 'webhook'])->name('paypal.webhook');
});

// Routes pour les paiements Afrikpay
Route::prefix('payment/afrikpay')->group(function () {
    Route::get('/return', [\App\Http\Controllers\PaymentControllers\AfrikpayController::class, 'return'])->name('afrikpay.return');
    Route::get('/cancel', [\App\Http\Controllers\PaymentControllers\AfrikpayController::class, 'cancel'])->name('afrikpay.cancel');
    Route::post('/webhook', [\App\Http\Controllers\PaymentControllers\AfrikpayController::class, 'webhook'])->name('afrikpay.webhook');
});

// Routes pour les paiements Flutterwave
Route::prefix('payment/flutterwave')->group(function () {
    Route::get('/return', [\App\Http\Controllers\PaymentControllers\FlutterwaveController::class, 'return'])->name('flutterwave.return');
    Route::post('/webhook', [\App\Http\Controllers\PaymentControllers\FlutterwaveController::class, 'webhook'])->name('flutterwave.webhook');
});

// Pages de résultat de paiement
Route::get('/subscription/success', [SubscriptionPlanController::class, 'showSuccessPage'])->name('subscription.success');
Route::get('/subscription/payment/error', [SubscriptionPlanController::class, 'showErrorPage'])->name('subscription.payment.error');
Route::get('/subscription/payment/cancelled', [SubscriptionPlanController::class, 'showCancelledPage'])->name('subscription.payment.cancelled');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/liste-piece-trouvee', [UserController::class, 'listing'])->name('find.list');
    Route::get('/ma-piece-trouvee', [UserController::class, 'myPiece'])->name('found.item');
    Route::get('/finder-user/{user}', [UserController::class, 'show'])->name('show.finder');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/{user}/updated', [UserController::class, 'update'])->name('user.update');
    Route::put('/changed-password/{user}', [UserController::class, 'updatePassword'])->name('user.update.password');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function (){
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
    
    // Routes pour la gestion des plans d'abonnement
    Route::resource('subscription-plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class);
    
    // Routes pour la gestion des devises
    Route::resource('currencies', \App\Http\Controllers\Admin\CurrencyController::class);
    Route::post('/currencies/sync-rates', [\App\Http\Controllers\Admin\CurrencyController::class, 'syncRates'])->name('currencies.sync-rates');
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
// Route accessible sans authentification (page d'accueil)
Route::get('/documents', [DocumentProtectionController::class, 'home'])->name('documents.home');

// Routes nécessitant une authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/documents/protect', [DocumentProtectionController::class, 'index'])->name('documents.protect');
    Route::post('/documents/protect', [DocumentProtectionController::class, 'protect'])->name('documents.protect');
    Route::get('/documents/{document}/download', [DocumentProtectionController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentProtectionController::class, 'destroy'])->name('documents.destroy');
});

require __DIR__.'/auth.php';