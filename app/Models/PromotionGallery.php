<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionGallery extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $appends = ['images_url'];
    protected $casts = [
        'images' => 'array'
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    // public function getImagesUrlAttribute()
    // {
    //     $basePath = asset('uploads/promotions');
    //     if (is_array($this->images) && !empty($this->images)) {
    //         return array_map(function ($images) use ($basePath) {
    //             return $basePath . '/' . $images;
    //         }, $this->images);
    //     }
    //     // return [asset('uploads/images/default-room.png')];
    //     return [];
    // }
}
