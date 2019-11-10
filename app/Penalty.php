<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penalty extends Model
{
    public $timestamps = false;
    protected $table = "penalty";
    protected $fillable = ["user_id", "penalty_end"];

    public function scopeNowPenaltyData($query, $user_id){
        $query->where("user_id",     "=", $user_id)
              ->where("penalty_end", ">", Carbon::now());
    }

    public function scopeOldPenaltyData($query, $user_id){
        $query->where("user_id", "=", $user_id)
              ->where("penalty_end", "<=", Carbon::now());
    }

    public function scopeAllPenaltyData($query, $user_id){
        $query->where("user_id", "=", $user_id);
    }
}
