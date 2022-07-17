<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'paragraph', 'status'];

    protected $table = "user_posts";

    function get_approved_post($user_id, $post_status)
    {
        return Post::select('user_posts.*', 'users.name')
            ->join('users', 'users.id', 'user_posts.user_id')
            ->where('user_posts.user_id', $user_id)
            ->where('status', $post_status)
            ->get();
    }
}
