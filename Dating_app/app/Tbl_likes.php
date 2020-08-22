<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tbl_likes extends Model
{
	protected $fillable = ['user_id', 'profile_id', 'likes', 'both_likes','dislikes'];
    public function users(){
        return $this->belongsTo(User::class);
    }
}
