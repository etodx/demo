<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $fillable = [
        'payment_type',
        'date',
        'room_id',
        'user_id'
    ];

    protected $hidden = [
        'id'
    ];

    protected function show ($id) {
        return Orders::findOrFail($id);
    }
    protected function showAll ($id) {
        return Orders::select()->where('id', $id)->get();
    }
}
