<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Models\Rooms;
use App\Models\Users;
use App\Models\Orders;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});
Route::get('/rooms', function(){
    return response()->json(Rooms::showAll());
});
Route::post('/order', function(Request $req){
    $validated = validate([
        'room_id'=>'required|number',
        'payment_type'=>'required|string',
        'date'=>'required|string',
        'status'=>'required|string'
    ]);
    Order::create([
        'user_id'=>Auth()->id,
        'payment_type'=>$validated['payment_type'],
        'date'=>$validated['date'],
        'room_id'=>$validated['room_id'],
    ]);
    return response()->json(['status'=>'200']);
});
Route::get('/type', function(){
    if(Users::isAdmin(Auth()->id)){
        return response()->json(['user_type'=>'admin']);
    }else{
        return response()->json(['user_type'=>'user']);
    }
});
Route::get('/orders', function(){
    log::Info(Orders::showAll(Auth()->id));
    return response()->json(Orders::showAll(Auth()->id));
});
Route::get('/rooms', function(){});


require __DIR__.'/settings.php';
