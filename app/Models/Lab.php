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
        'rating',
        'in_stock',
        'condition',
        'price',
        'unit',
        'desc',
        "purchaseType",
    ];

    protected $casts = [
        'images' => 'array', // Casts the JSON field to an array
    ];
    protected $attributes = [
        'images' => '[]', // Default value for images
    ];
    protected $appends = [ 'avatar_url', 'images_url'];

    
   
    public function getAvatarUrlAttribute()
    {
        return url('storage/' . $this->avatar);
    }
    public function getImagesUrlAttribute()
    {
        return array_map(function ($image) {
            return url('storage/' . $image);
        }, $this->images ?? []);
    }

}
