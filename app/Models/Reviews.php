<?php

namespace App\Models;
use App\Models\Orders;
use App\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [
        'rating',
        'review',
        'order_id',
        'user_id'
    ];

    protected $hidden = [
        'id'
    ];
    protected function show ($id) {
        return Reviews::findOrFail($id);
    }
    protected function showAll () {
        return Reviews::all();
    }
    protected function order(){
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
    protected function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
