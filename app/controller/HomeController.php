<?php

// namespace
namespace app\controller;

class HomeController extends BaseController
{
    public function home()
    {
        $this->render_view("page:home");
    }
}
