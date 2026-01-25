<?php
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// RUTA PÚBLICA: Todos pueden ver los animales
Route::get('/', [AnimalController::class, 'index'])->name('animals.index');

// RUTAS DE AUTENTICACIÓN (Para invitados)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// RUTAS PROTEGIDAS (Solo para usuarios logueados)
Route::middleware('auth')->group(function () {
    Route::get('/mis-animales', [AnimalController::class, 'myAnimals'])->name('animals.mine');
    Route::resource('animals', AnimalController::class)->except(['index']);
    Route::post('/animals/{animal}/adopt', [AdoptionController::class, 'store'])->name('adopt.store');
    Route::get('/notificaciones', [AnimalController::class, 'notifications'])->name('notifications.index');
    Route::get('/notificaciones/unread-count', [AnimalController::class, 'unreadNotificationsCount'])->name('notifications.unread-count');
    Route::get('/notificaciones/unread', [AnimalController::class, 'unreadNotifications'])->name('notifications.unread');
    Route::patch('/notificaciones/{id}/leida', [AdoptionController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Settings routes (profile, password, 2FA)
require __DIR__.'/settings.php';