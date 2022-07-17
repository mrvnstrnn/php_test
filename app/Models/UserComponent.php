<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserComponent extends Model
{
    use HasFactory;

    protected $fillable = ['components', 'user_id'];

    protected $table = "user_components";
}
