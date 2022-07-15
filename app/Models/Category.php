<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'slug'];

    public function chuldrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

     public function parentCategories()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->parentCategories()->with('parent');
    }

    public function children()
    {
     return $this->chuldrenCategories()->with('children');
    }

}
