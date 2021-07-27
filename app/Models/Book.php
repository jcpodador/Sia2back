<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'summary',
        'price',
        'type',
        'user_id'

    ];

    public function container() {
        return $this->belongsTo('App\Models\Book', 'author', 'id');
    }
}
