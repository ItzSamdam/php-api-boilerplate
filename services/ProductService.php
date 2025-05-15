/**
* services/ProductService.php - Product service layer
*/
<?php

namespace Services;

use Models\Product;

class ProductService
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
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
