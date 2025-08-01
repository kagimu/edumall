<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
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
        'condition' => 'new', // Default condition
    ];
    protected $appends = [
        'avatar_url',
        'images_url',
    ];
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }
    public function getImagesUrlAttribute()
    {
        return array_map(function ($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }
    public function getCategoryAttribute($value)
    {
        return $value === 'sound' ? 'Sound Systems' : 'Tents';
    }
}
