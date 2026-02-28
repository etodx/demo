<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rooms; 
use App\Models\Users;

class Orders extends Model
{

    protected $fillable = [
        'payment_type',
        'date',
        'room_id',
        'user_id'
    ];

    protected $hidden = [
        'id',
        'type'
    ];

    protected function show ($id) {
        return Orders::findOrFail($id);
    }
    protected function showAll ($id) {
        return Orders::select()->where('id', $id)->get();
    }
    protected function room(){
        return $this->belongsTo(Room::class, 'id', 'room_id');
    }
    protected function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
