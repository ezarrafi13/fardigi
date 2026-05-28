<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category_id', 'sku', 'name', 'description',
        'price', 'stock', 'datasheet_tips', 'pinout_data', 'image_url',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPinoutArrayAttribute(): array
    {
        return $this->pinout_data ? json_decode($this->pinout_data, true) ?? [] : [];
    }
}
