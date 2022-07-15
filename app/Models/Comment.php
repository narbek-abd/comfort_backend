<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'text', 'product_id', 'parent_id'];

    public function replies()
    {
        return $this->recursive_replies()->with('replies');
    }

    public function recursive_replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
