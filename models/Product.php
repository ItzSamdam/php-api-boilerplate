<?php

require_once __DIR__ . '/../models/BaseModel.php';

class Product extends BaseModel
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'category_id'

    // You can add more fields as needed, such as 'role', 'created_at', 'updated_at', etc.
    ];

    // Product belongs to a Category
    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id');
    // }

    // // Product has many Orders
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'product_id');
    // }
}
