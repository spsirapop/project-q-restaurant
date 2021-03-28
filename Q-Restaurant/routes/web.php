<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QueueController;
use App\Models\Queue;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', function () {
    $queues = Queue::paginate(5);
    $queueAll= Queue::all();
   // $users = User::all();
   // $queues = Queue::all();
    return view('dashboard',compact('queues','queueAll'));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified','authadmin'])->get('/admin/dashboard', function () {
    $users = User::all();
    return view('admin.dashboard',compact('users'));
})->name('admin.dashboard');



Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/queue/all',[QueueController::class,'index'])->name('queue');

    Route::get('/queue/user/all',[QueueController::class,'indexUser'])->name('queueUser');

    Route::post('/queue/add',[QueueController::class,'store'])->name('addQueue');
    Route::get('/queue/edit/{id}',[QueueController::class,'edit'])->name('edit');
    
    Route::get('/queue/softdelete/{id}',[QueueController::class,'softdelete'])->name('softdelete');
    Route::post('/queue/update/{id}',[QueueController::class,'update']);

    Route::get('/queue/restore/{id}',[QueueController::class,'restore']);
    Route::get('/queue/delete/{id}',[QueueController::class,'delete']);

    Route::post('/queue/search/',[QueueController::class,'search'])->name('search');


});



