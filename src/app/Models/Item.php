<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const STATUS_UNSOLD = 0;
    const STATUS_SOLD   = 1;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'name', 'price', 'brand', 'description', 'condition', 'status', 'user_id'
    ];

    public function images()
    {
       return $this->hasMany(ItemImage::class);
    }

        public function favorites()
    {
       return $this->hasMany(Favorite::class);
    }

    public function purchases()
    {
       return $this->hasOne(Purchase::class);
    }

     public function comments()
    {
       return $this->hasMany(Comment::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
      if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
      }
      return $query;
    }

    public function categories()
    {
    return $this->belongsToMany(Category::class);
    }
}
