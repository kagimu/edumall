<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Furniture extends Model
{
    use HasFactory;
    protected $table = 'furniture';
    protected $fillable = [
        'name',
        'category',
        'avatar',
        'images',
        'color',
        'brand',
        'in_stock',
        'condition',
        'price',
        'discount',
        'desc'
    ];

    protected $casts = [
        'images' => 'array', // Cast images to array
    ];
    protected $attributes = [
        'category' => 'office', // Default category
        'condition' => 'new', // Default condition
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $appends = [
        'images_url',
        'avatar_url',
    ];
    public function getImagesUrlAttribute()
    {
        return array_map(function ($image) {
            return url('storage/' . $image);
        }, $this->images);
    }
    public function getAvatarUrlAttribute()
    {
        return url('storage/' . $this->avatar);
    }
}
