<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['name', 'price', 'category_id', 'description', 'details', 'quantity'];

    public function category()
    {
        return $this->belongsTo(Category::class)->with('parent');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->with('replies');
    }
}
