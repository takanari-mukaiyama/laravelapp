<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ["role_id", "role_name"];

    public function scopeGetRoleDataByRoleId($query, $role_id){
        $query->where("role_id", "=", $role_id);
    }
}
