<?php

namespace Services;

require_once __DIR__ . '/../models/Product.php';

use Product;

class ProductService
{
    public function getAllProducts()
    {
        // Using query builder
        return Product::query()->get();
    }

    public function getProductById($id)
    {
        return Product::query()->find($id);
    }

    public function createProduct($data)
    {
        return Product::query()->create($data);
    }

    public function updateProduct($id, $data)
    {
        return Product::query()->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return Product::query()->delete($id);
    }
}
