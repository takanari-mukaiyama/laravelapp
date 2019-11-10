<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = "book_detail";
    protected $primaryKey = "book_id";
    protected $guarded = array("book_id");

    public function scopeSearchBooks($query, $freeword){
        $query->whereRaw("MATCH(book_title) 
                          AGAINST (? IN BOOLEAN MODE) 
                          OR MATCH(book_detail) 
                          AGAINST (? IN BOOLEAN MODE)
                          ORDER BY book_id desc",[$freeword, $freeword]
                        );
    }
}
