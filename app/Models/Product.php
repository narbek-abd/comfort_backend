<?php

namespace App\Models;

use App\Models\Category;
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
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
