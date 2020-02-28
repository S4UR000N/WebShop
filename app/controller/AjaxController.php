<?php

// namespace
namespace app\controller;

// class
class AjaxController
{
    public function validatePurchase()
    {
        $ajaxModel = new \app\model\AjaxModel();
        $ajaxModel->validatePurchase();
	}

    public function validateVote()
    {
        $ajaxModel = new \app\model\AjaxModel();
        $ajaxModel->validateVote();
	}
}
