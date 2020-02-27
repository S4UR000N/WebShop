<?php

// namespace
namespace app\model;

class AjaxModel extends BaseModel
{
    public function validatePurchase()
    {
        // store $post & $session
        $post = new \app\super\Post();
        $session = new \app\super\Session();

        // get front end data
        $token = $post->get("token");

        $products = json_decode($post->get("products"));
        $shipping = $post->get("shipping");

        /* Validate Data */
        // error holder
        $error = "";

        // validate CSRF Token
        if(!$post->isSet("token"))
        {
            $error = "Invalid Request!";
        }
        else
        {
            if(!hash_equals($session->get("token"), $post->get("token")))
            {
                $error = "Invalid Request!";
            }
        }

        // validate shipping
        $shippingMethods =
        [
                "PU" => 0,
                "UPS" => 5
        ];
        if(empty($error))
        {
            if(!in_array($shipping, $shippingMethods))
            {
                $error = "Shipping method is not set!";
            }
        }

        // validate Products
        $IDs = [];
        $billProducts = [];
        if(empty($error))
        {
            // store all IDs if they are valid numbers or throw an error
            foreach($products as $product)
            {
                if(!is_numeric($product->id))
                {
                    $error = "Invalid product ID!";
                    break;
                }
                array_push($IDs, $product->id);
            }
        }

        $price = 0;
        if(empty($error))
        {
            // check if products are valid and exist in the database
            $productRepo = new \app\repository\ProductRepository();
            $products = $productRepo->selectProductsWhereIDs($IDs);

            if(count($products) !== count(array_unique($IDs)))
            {
                $error = "Invalid product ID!";
            }

            // check if user has enough money, calcualte the price and deduct the balance or throw an error
            else
            {
                foreach($IDs as $id)
                {
                    foreach($products as $product)
                    {
                        if($product["id"] == $id)
                        {
                            array_push($billProducts, $product);
                            $price += $product["price"];
                            break;
                        }
                    }
                }
                $price += $shipping;

                if($session->get("balance") < $price)
                {
                    $error = "Insufficient funds!";
                }
                else
                {
                    $session->set("balance", ($session->get("balance") - $price));
                }
            }
        }

        // Output Holder
        $data =
        [
            "error" => $error,
            "price" => $price,
            "balance" => $session->get("balance"),
            "products" => $billProducts
        ];

        // Return Data
        echo json_encode($data);
    }
}
