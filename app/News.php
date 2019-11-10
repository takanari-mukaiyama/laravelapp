<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";
    protected $fillable = ["news_title", "section"];

    public function scopeSortNewest($query){
        $query->orderBy("created_at", "desc");
    }

    public function scopeGetOne($query, $id){
        $query->where("id", "=", $id);
    }
}
