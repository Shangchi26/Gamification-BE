<?php

use App\Http\Controllers\Admin\ChestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\QuestController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/login', [UserController::class, 'showAdminLoginForm']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'showDashboard']);

    // Chest Management
    Route::prefix('/admin/chest-manage')->group(function () {
        Route::get('/', [ChestController::class, 'showAllChest']);
        Route::get('/create', [ChestController::class, 'createChestForm']);
        Route::post('/create', [ChestController::class, 'createChest'])->name('chest.create');
        Route::delete('/delete-{id}', [ChestController::class, 'deleteChest'])->name('chest.delete');
        Route::get('/update-{id}', [ChestController::class, 'updateChestForm']);
        Route::put('/update-{id}', [ChestController::class, 'updateChest'])->name('chest.update');
        Route::get('/chest-{id}-detail', [ChestController::class, 'chestDetail']);
    });

    // Item Management
    Route::prefix('/admin/item-manage')->group(function () {
        Route::get('/', [ItemController::class, 'itemManage']);
        Route::get('/create', [ItemController::class, 'createItemForm']);
        Route::post('/create', [ItemController::class, 'createItem'])->name('item.create');
        Route::get('/item-{id}-detail', [ItemController::class, 'itemDetail']);
        Route::get('/item-{id}-update', [ItemController::class, 'updateItemForm']);
        Route::put('/item-{id}-update', [ItemController::class, 'updateItem'])->name('item.update');
        Route::delete('/delete-{id}', [ItemController::class, 'deleteItem'])->name('item.delete');
        Route::put('/update-{id}-status', [ItemController::class, 'updateRewardStatus'])->name('reward.update');
    });

    // Package Management
    Route::prefix('/admin/package-manage')->group(function () {
        Route::get('/', [PackageController::class, 'packageManage']);
        Route::get('/create', [PackageController::class, 'createPackageForm']);
        Route::post('/create', [PackageController::class, 'createPackage'])->name('package.create');
        Route::get('/package-{id}-detail', [PackageController::class, 'packageDetail']);
        Route::get('/update-{id}', [PackageController::class, 'updatePackageForm']);
        Route::put('/update-{id}', [PackageController::class, 'updatePackage'])->name('package.update');
        Route::delete('/delete-{id}', [PackageController::class, 'deletePackage'])->name('package.delete');
    });

    // Quest Management
    Route::prefix('/admin/quest-manage')->group(function () {
        Route::get('/', [QuestController::class, 'questManage']);
        Route::get('/create', [QuestController::class, 'createQuestForm']);
        Route::post('/create', [QuestController::class, 'createQuest'])->name('quest.create');
        Route::get('/update-{id}', [QuestController::class, 'updateQuestForm']);
        Route::put('/update-{id}', [QuestController::class, 'updateQuest'])->name('quest.update');
        Route::delete('/delete-{id}', [QuestController::class, 'deleteQuest'])->name('quest.delete');
    });

    // User Management
    Route::prefix('/admin/user-manage')->group(function () {
        Route::get('/', [UserController::class, 'userManage']);
        Route::put('/ban-{id}', [UserController::class, 'banUser'])->name('user.ban');
        Route::put('/unban-{id}', [UserController::class, 'unbanUser'])->name('user.unban');
    });

});

