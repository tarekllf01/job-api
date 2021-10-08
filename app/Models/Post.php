<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "posts";

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'updated_by_user_id',
        'thumbnail',
        'status',
    ];

    public function userInfo ()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
