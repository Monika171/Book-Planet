<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function scopeFilter($query, array $filters)
    {
        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%'.request('search').'%')
                ->orWhere('author', 'like', '%'.request('search').'%');
        }
    }
}
