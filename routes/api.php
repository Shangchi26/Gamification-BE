<?php

use App\Http\Controllers\ChestController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/all-chests', [ChestController::class, 'getAllChests']);

Route::post('/chest-claim', [InventoryController::class, 'claimChest']);
Route::get('/inventories', [InventoryController::class, 'inventories']);

Route::get('/chest-open', [ItemController::class, 'openChest']);

Route::post('/invitation', [InvitationController::class, 'invitation']);

Route::post('/checkout', [PackageController::class, 'order']);
Route::get('/all-package', [PackageController::class, 'showAllPackages']);

Route::get('/quest-progess', [QuestController::class, 'questProgess']);
Route::post('/complete-quest', [QuestController::class, 'completeQuest']);

Route::get('/list-winner', [RewardController::class, 'listWinner']);
