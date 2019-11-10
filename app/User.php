<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'password', 'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserName($user_id){
        $user = self::where("user_id", $user_id)->first();
        return $user["name"];
    }

    public function scopeGetUserInfo($query, $user_id){
        return $query->where("user_id", $user_id);
    }

    public function scopeUserSearch($query, $freeword){
        $query->where("user_id", "LIKE", "%$freeword%")
              ->orWhere("name", "LIKE", "%$freeword%")
              ->orderBy("created_at", "desc");
    }

    public function getPenalty(){
        return $this->hasOne("App\Penalty", "user_id", "user_id");
    }

    public function getRoleName(){
        return $this->hasOne("App\Role", "role_id", "role");
    }
}
