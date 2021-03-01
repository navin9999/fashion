<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('Admin.dashboard');
})->name('dashboard');

Route::get('/category-tree-view', [CategoryController::class, 'manageCategory']);
Route::post('/add-category', [CategoryController::class, 'addCategory']);

// Route::get('category-tree-view',['uses'=>'CategoryController@manageCategory']);
// Route::post('add-category',['as'=>'add.category','uses'=>'CategoryController@addCategory']);