<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = ['title', 'author'];
    
    // Search for books
    public function scopeFilter($query, $filter)
    {
        if($filter ?? false) {
            $query->where('title', 'like', '%'.request('search').'%')
                  ->orWhere('author', 'like', '%'.request('search').'%');
        }
    }

    // Sort books
    public function scopeSort($query, $column, $direction)
    {
        $query->orderBy($column, $direction);
    }
}
