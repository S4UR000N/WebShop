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
        if(!empty($ratings))
        {
            if(array_key_exists($productID, $ratings))
            {
                $votes_value = $validProduct["votes_value"] + $rating - $ratings[$productID];
                $votes = $validProduct["votes"];
            }
        }
        // store rating to session $ratings
        $session->setRating($productID, $rating);
        $ratings = $session->get("rating");

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
    "session" => json_encode($_SESSION),
    "ratings" => json_encode($ratings),
    "rating" => $rating
];

// Return Data
echo json_encode($data);
