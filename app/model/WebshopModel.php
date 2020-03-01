<?php

// namespace
namespace app\model;

class WebshopModel extends BaseModel
{
    public function setCSRFtoken()
    {
        if(!$session->isSet("token"))
        {
            $session->set("token", bin2hex(random_bytes(32)));
        }
    }

    public function setRatings() {
        if($session->isSet("rating"))
        {
            $ratings = json_encode($session->get("rating"));
        }
        else
        {
            $ratings = json_encode(false);
        }
    }

    public function setBalance()
    {
        if(!$session->isSet("balance"))
        {
            $session->set("balance", "100");
        }
    }

    public function getAllProductsAsJSON()
    {
        $productRepository = new \app\repository\ProductRepository();
        $products = $productRepository->selectAllProducts();
        $products = json_encode($products);
        return $products;
    }

}
