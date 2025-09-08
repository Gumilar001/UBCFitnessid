<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\UserMembershipController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrainerBookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsStaff;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\CheckinController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'] )
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/user_dashboard', function () {
    return view('user_dashboard');
})->middleware(['auth', 'verified'])->name('user_dashboard');

Route::get('/pt_dashboard', function () {
    return view('pt_dashboard');
})->middleware(['auth', 'verified'])->name('pt_dashboard');

Route::get('/trainer-dashboard', [TrainerBookingController::class, 'trainerDashboard'])
    ->name('trainer.dashboard')
    ->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * ========================
 * ADMIN ROUTES
 * ========================
 */
Route::middleware(['auth', 'role:admin'])->group(function () {
    

    // Admin juga bisa kelola Membership
    Route::resource('memberships', MembershipController::class);

    // Kelola Produk
    Route::resource('products', App\Http\Controllers\ProductController::class);    
});

/**
 * ========================
 * ADMIN & STAFF ROUTES
 * ========================
 * (Bisa kelola transactions & user-memberships)
 */
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    // Kelola User
    Route::resource('users', UserController::class);

    // Kelola Transactions
    Route::resource('transactions', TransactionController::class);

    // Kelola User Memberships
    Route::resource('user-memberships', UserMembershipController::class);
    Route::get('user-memberships/{id}/print', [UserMembershipController::class, 'print'])->name('user-memberships.print');    

    // Booking Trainer
    Route::get('/booking/create', [TrainerBookingController::class, 'create'])->name('booking.create')->middleware('auth');
    Route::post('/booking/store', [TrainerBookingController::class, 'store'])->name('booking.store')->middleware('auth');

    // Checkins
    Route::get('/checkins', [CheckinController::class, 'index'])->name('checkins.index');
    Route::post('/checkins', [CheckinController::class, 'store'])->name('checkins.store');

});

/**
 * ========================
 * STAFF ROUTES
 * ========================
 * (Staff hanya bisa lihat membership)
 */
Route::middleware(['auth', 'role:staff'])->group(function () {

    // POS
    Route::get('/pos/membership-detail', [POSController::class, 'getMembershipDetail']);
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/transaction', [POSController::class, 'storeTransaction'])->name('pos.transaction');

    // Shift
    Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::post('/shift/open', [ShiftController::class, 'open'])->name('shift.open');
    Route::post('/shift/close', [ShiftController::class, 'close'])->name('shift.close');

    // membership
    Route::get('/staff/memberships', [MembershipController::class, 'index'])->name('staff.memberships.index');


    Route::get('/staff/users', [UserController::class, 'index'])->name('staff.users.index');
    Route::get('/staff/transactions', [TransactionController::class, 'index'])->name('staff.transactions.index');
    Route::get('/staff/user-memberships', [UserMembershipController::class, 'index'])->name('staff.user-memberships.index');
});

/**
 * ========================
 * USER ROUTES
 * ========================
 */
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/my-memberships', [UserMembershipController::class, 'myMemberships'])->name('user.my-memberships');
    Route::get('/my-transactions', [TransactionController::class, 'myTransactions'])->name('user.my-transactions');
});


require __DIR__.'/auth.php';
