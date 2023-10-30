<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table    = 'movies';
    protected $guarded  = [];

    public function scopeSearch($query, $searchText)
    {
        $query->when($searchText, function ($q, $text) {
            return $q
                ->where('name', 'LIKE', "%$text%");
        });
    }
}
