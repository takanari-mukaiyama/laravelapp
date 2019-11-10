<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    public $timestamps = false;
    protected $table = "rental";
    protected $fillable = [
        "user_id",
        "book_id",
        "book_number",
        "rent_date",
        "deadline",
        "return_date",
    ];

    public function scopeNowRentalData($query, $request){
        $query->where("book_id",     "=", $request->book_id)
            ->where(  "book_number", "=", $request->book_number)
            ->whereNull("return_date");
    }
}
