<?php

// namespace
namespace app\model;

class UserModel extends BaseModel
{
    // constructor
    public function __construct()
    {
        if(\app\super\Session::isSet())
        {
            $session = new \app\super\Session();
            $this->user_id = $session->get('user_id');

            $userRepo = new \app\repository\UserRepository();
            $userData = $userRepo->selectOneById($this->user_id);

            if(!empty($userData))
            {
                $userData = $userData[0];
            }

            $this->user_name = $userData['user_name'];
            $this->user_email = $userData['user_email'];
            $this->user_password = $userData['user_password'];
        }
    }
}