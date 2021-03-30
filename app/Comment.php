<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public function replies(){
        return $this->hasMany('App\Comment', 'comment_id', 'id');
    }
    
    public function replies2(){
        return $this->hasMany('App\Comment', 'comment_id', 'id');
    }

}
