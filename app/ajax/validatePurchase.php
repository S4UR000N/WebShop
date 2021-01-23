<?php

// include files
include "../super/Post.php";
include "../super/Session.php";
include "../extra/Connection.php";
include "../repository/BaseRepository.php";
include "../repository/ProductRepository.php";

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
$vertifiedProducts = [];
if(empty($error))
{
    // store all IDs if they are valid numbers or throw an error
    foreach($products as $product)
    {
        if(!is_numeric($product->obj->id))
        {
            $error = "Invalid product ID!";
            break;
        }
        array_push($IDs, $product->obj->id);
    }
}

$price = 0;
if(empty($error))
{
    // check if products are valid and exist in the database
    $productRepo = new \app\repository\ProductRepository();
    $productsDB = $productRepo->selectProductsWhereIDs($IDs);

    if(count($productsDB) !== count(array_unique($IDs)))
    {
        $error = "Invalid product ID!";
    }

    // check if user has enough money, calcualte the price and deduct the balance or throw an error
    else
    {
        foreach($IDs as $id)
        {
            foreach($productsDB as $product)
            {
                if($product["id"] == $id)
                {
                    array_push($vertifiedProducts, $product);
                    break;
                }
             }
        }

        // multiply product price with product count
        foreach($vertifiedProducts as $key => $vertifiedProduct)
        {
            foreach($products as $product)
            {
                if($product->obj->id == $vertifiedProduct["id"])
                {
                    // increment price
                    $price += ((int)$product->count * $vertifiedProduct["price"]);

                    // add product count to vertified Product
                    $vertifiedProducts[$key]["count"] = $product->count;
                    break;
                }
            }
        }

        // add shipping to the cost
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
    "products" => $vertifiedProducts
];

// Return Data
echo json_encode($data);
