<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerLab extends Model
{
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
    public function getImagesArrayAttribute()
    {
        return json_decode($this->images, true);
    }
}
