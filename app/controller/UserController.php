<?php

// namespace
namespace app\controller;

class UserController extends BaseController
{
    // View Data
    public $viewData = array();

    public function registration()
    {
        $this->denyIn();
        $registrationModel = new \app\model\RegistrationModel();
        $registrationModel->registration($this);
    }

    public function login()
    {
        $this->denyIn();
        $loginModel = new \app\model\LoginModel();
        $loginModel->login($this);
    }

    public function logout()
    {
        new \app\model\LogoutModel();
    }

    public function management()
    {
        $this->denyOut();
        $managementModel = new \app\model\ManagementModel();
        $managementModel->management($this);
    }
    public function myaccount()
    {
        $this->denyOut();
        $myaccountModel = new \app\model\MyaccountModel();
        $myaccountModel->myaccount($this);
    }
}
