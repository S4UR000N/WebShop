<?php

// namespace
namespace app\model;

class WebshopModel extends BaseModel
{
    public function getAllProductsAsJSON()
    {
        $productRepository = new \app\repository\ProductRepository();
        $products = $productRepository->selectAllProducts();
        $products = json_encode($products);
        return $products;
    }

}
