<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Lab extends Model
{
    use HasFactory;
    protected $table = 'labs';

  


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
        'desc',
    ];

    protected $casts = [
        'images' => 'array', // Casts the JSON field to an array
    ];
    protected $attributes = [
        'images' => '[]', // Default value for images
    ];
    protected $appends = ['images_array', 'avatar_url', 'images_url'];

    
    public function getImagesArrayAttribute()
    {
        return json_decode($this->images, true);
    }
    public function getAvatarUrlAttribute()
    {
        return url('storage/' . $this->avatar);
    }
    public function getImagesUrlAttribute()
    {
        $images = $this->images;
        // Ensure $images is an array
        if (!is_array($images)) {
            $images = json_decode($images, true) ?: []; // Fallback to an empty array if decoding fails
        }

        return array_map(function ($image) {
            return url('storage/' . $image);
        }, $images);
    }

}
