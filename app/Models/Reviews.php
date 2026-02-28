<?php

namespace App\Models;

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
}
