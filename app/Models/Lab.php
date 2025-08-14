<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'images' => 'array',
    ];

    protected $attributes = [
        'images' => '[]',
    ];

    protected $appends = [ 'avatar_url', 'images_url' ];

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }

        // If avatar is a full URL (e.g. Imgur), return it as is
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        return asset('storage/' . $this->avatar);
    }

   public function getImagesUrlAttribute()
{
    $images = $this->images;

    // Handle case where images might be stored as JSON string
    if (is_string($images)) {
        $decoded = json_decode($images, true);
        $images = is_array($decoded) ? $decoded : [];
    }

    return array_map(function ($image) {
        // If the image path is a full URL, return it directly
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // Otherwise, build the storage asset URL
        return asset('storage/' . $image);
    }, $images ?? []);
}

}
