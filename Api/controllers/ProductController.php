/**
* controllers/ProductController.php - Product controller
*/
<?php

namespace Api\Controllers;

use Api\Utils\Request;
use Api\Utils\Response;
use Api\Utils\Validator;
use Api\Services\ProductService;

class ProductController
{
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAllProducts();
        return Response::success($products);
    }

    public function show(Request $request, $params)
    {
        $product = $this->productService->getProductById($params['id']);

        if (!$product) {
            return Response::notFound('Product not found');
        }

        return Response::success($product);
    }

    public function store(Request $request)
    {
        $body = $request->getBody();

        $validator = new Validator($body);
        $validator->required('name')
            ->required('price')
            ->numeric('price')
            ->required('description');

        if (!$validator->isValid()) {
            return Response::validationError($validator->getErrors());
        }

        $product = $this->productService->createProduct($body);
        return Response::success($product, 'Product created successfully', 201);
    }

    public function update(Request $request, $params)
    {
        $body = $request->getBody();

        $validator = new Validator($body);

        if (isset($body['price'])) {
            $validator->numeric('price');
        }

        if (!$validator->isValid()) {
            return Response::validationError($validator->getErrors());
        }

        $product = $this->productService->updateProduct($params['id'], $body);

        if (!$product) {
            return Response::notFound('Product not found');
        }

        return Response::success($product, 'Product updated successfully');
    }

    public function destroy(Request $request, $params)
    {
        $result = $this->productService->deleteProduct($params['id']);

        if (!$result) {
            return Response::notFound('Product not found');
        }

        return Response::success(null, 'Product deleted successfully');
    }
}
