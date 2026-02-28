<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $fillable = [
        'room_type',
        'price',
        'capacity'
    ];

    protected $hidden = [
        'id'
    ];
    protected function show ($id) {
        return Rooms::findOrFail($id);
    }
    protected function showAll () {
        return Rooms::all();
    }
}
