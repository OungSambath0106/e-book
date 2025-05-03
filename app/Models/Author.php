<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['image_url'];

    protected $table = 'authors';

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin')) {
            return $name;
        }
        return $this->translations[0]->value ?? $name;
    }

    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        } else {
            if (!empty($this->image)) {
                return asset('uploads/authors/' . rawurlencode($this->image));
            } else {
                return asset('uploads/man.png');
            }
        }
    }
}
