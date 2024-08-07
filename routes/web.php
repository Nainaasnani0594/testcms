<?php
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::resource('permissions', App\Http\Controllers\PermissionController::class);


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('/projects', ProjectController::class);
        Route::resource('/groups', GroupController::class);
        Route::resource('/tasks', TaskController::class);
        Route::get('/overview', [OverviewController::class, 'index'])->name('overview.index');
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.assignRole');
        Route::post('/groups/{group}/toggle-freeze-month', [GroupController::class, 'toggleFreezeMonth'])->name('groups.toggle-freeze-month');

    });
// User Routes

    Route::middleware('role:user')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
        Route::resource('/projects', ProjectController::class);
        Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
        });
    
   // Profile Routes
   Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

});
require __DIR__ . '/auth.php';