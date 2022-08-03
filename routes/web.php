<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\profileController;
use App\Models\profile;

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

Route::middleware([
    "auth", "verified"
])
    //->prefix('app')
    //->as('app.')
    //->namespace('\App\Http\Controllers')
    ->group(function () {
        Route::get('/', [PostsController::class, 'index'])->middleware();
        /////trash,restore,forceDelete
        Route::get("/posts/trash", [PostsController::class, "trash"]);
        Route::put("/posts/{id}/restore", [PostsController::class, "restore"]);
        Route::delete("/posts/{id}/forceDelete", [PostsController::class, "forceDelete"]);
        /////resource
        Route::get("/posts", [PostsController::class, "index"]);
        Route::get("/posts/create", [PostsController::class, "create"]);
        Route::post("/posts", [PostsController::class, "store"]);
        Route::get("/posts/{id}", [PostsController::class, "show"]);
        Route::get("/posts/{id}/edit", [PostsController::class, "edit"]);
        Route::put("/posts/{id}", [PostsController::class, "update"]);
        Route::delete("/posts/{id}", [PostsController::class, "destroy"]);
        //comments
        Route::post("/comments", [CommentsController::class, 'store'])->name('comments.store');
        //profile
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/edit', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/u/{username?}', [profileController::class, 'index'])->name('profile.index');
        //follow
        Route::post('follow', [ProfileController::class, 'follow'])->name('follow');
        Route::post('unfollow', [ProfileController::class, 'unfollow'])->name('unfollow');
        //notification
        Route::get("notification", [notificationController::class, "index"])->name("notifications");
        Route::get("/notification/{id}", [notificationController::class, "show"])->name("notifications.show");
        Route::delete("/notification/{id}", [notificationController::class, "destroy"])->name("notifications.destroy");
    });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
