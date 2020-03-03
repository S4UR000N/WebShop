<?php

// namespace
namespace app\model;

class WebshopModel extends BaseModel
{
    public function setCSRFtoken($session)
    {
        if(!$session->isSet("token"))
        {
            $session->set("token", bin2hex(random_bytes(32)));
        }
    }

    public function setRatings($session) {
        if($session->isSet("rating"))
        {
            return json_encode($session->get("rating"));
        }
        else
        {
            return json_encode([]);
        }
    }

    public function setBalance($session)
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
