<?php

namespace Services;

require_once __DIR__ . '/../models/Product.php';
// Adjust the namespace below if your Product model uses a different namespace
use Product;

class ProductService
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = \Database::getInstance()->getConnection();
        $this->productModel = new Product($this->db);
    }

    public function getAllProducts()
    {
        return $this->productModel->findAll();
    }

    public function getProductById($id)
    {
        return $this->productModel->findById($id);
    }

    public function createProduct($data)
    {
        return $this->productModel->create($data);
    }

    public function updateProduct($id, $data)
    {
        return $this->productModel->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->productModel->delete($id);
    }
}
