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

    public function validateVote()
    {
        // store $post & $session
        $post = new \app\super\Post();
        $session = new \app\super\Session();

        // get front end data
        $token = $post->get("token");

        $productID = $post->get("productID");
        $rating = $post->get("rating");
        $ratings = json_decode($post->get("ratings"), true);

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

        // validate product and calculate, save new product rating
        if(empty($error))
        {
            // validate product's id or throw an error
            $productRepo = new \app\repository\ProductRepository();
            $validProduct = $productRepo->selectProductWhereID($productID);
            if(!$validProduct)
            {
                $error = "Invalid product ID!";
            }
            // validate user's vote or throw and error
            else
            {
                if($rating < 1 && $rating > 5)
                {
                    $error = "Invalid Vote!";
                }
            }

            // calculate and save new product rating
            if(empty($error))
            {
                $votes_value = $validProduct["votes_value"] + $rating;
                $votes = $validProduct["votes"] + 1;

                // check if user aleready rated this product
                if($ratings)
                {
                    if(array_key_exists($productID, $ratings))
                    {
                        $votes_value = $validProduct["votes_value"] + $rating - $ratings[$productID];
                        $votes = $validProduct["votes"];
                    }
                }

                // store rating to session
                $session->setRating($productID, $rating);

                // calculate new rating
                $rating = $votes_value / $votes;

                // store new data to database
                $updateSuccessful = $productRepo->updateRatingData($votes, $votes_value, $rating, $productID);

                // if update failed throw error
                if(!$updateSuccessful)
                {
                    $error = "Rating the product failed!";
                }
            }
        }

        // Output Holder
        $data =
        [
            "error" => $error,
            "rating" => $rating
        ];

        // Return Data
        echo json_encode($data);
    }
}
