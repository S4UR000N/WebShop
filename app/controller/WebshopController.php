<?php

// namespace
namespace app\controller;

class WebshopController extends BaseController
{
    // View Data
    public $viewData = array();

    public function webshop()
    {
        // instantiate needed classes
        $session = new \app\super\Session();
        $webshopModel = new \app\model\WebshopModel();

        // set csrf token
        $webshopModel->setCSRFtoken();

        // set ratings
        $webshopModel->setRatings();

        // set balance
        $webshopModel->setBalance();

        // get products from DB
        $products = $webshopModel->getAllProductsAsJSON();

        // store token, balance and products as $viewData
        $this->viewData["token"] = $session->get("token");
        $this->viewData["balance"] = $session->get("balance");
        $this->viewData["ratings"] = $ratings;
        $this->viewData["products"] = $products;

        // render view with $viewData attached
        $this->render_view("page:webshop", $this->viewData);
    }
}
