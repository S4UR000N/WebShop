<?php

// namespace
namespace app\model;

class AjaxModel extends BaseModel
{
    public function test()
    {
        echo "lol";
    }
    public function validatePurchase()
    {
        // store $post & $session
        $post = new \app\super\Post();
        $session = new \app\super\Session();

        // decode front end json
        $products = json_decode($post->get("products"));

        // Output Holder
        $data = 1;

        if(true)
        {
            var_dump($products);
        }
        else
        {
            echo 0;
        }
    }
}
