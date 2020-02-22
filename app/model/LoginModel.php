<?php

// namespace
namespace app\model;

class LoginModel extends UserModel
{
    public function login(\app\controller\UserController $parentObject)
    {
        if (!\app\extra\Request::requestMethod()) {
            $parentObject->render_view("out:login");
        }
        else
        {
            /// store $post & $session
            $post = new \app\super\Post();
            $session = new \app\super\Session();

            $post = $post->getPost();

            
            // Final View Data
            $viewData = array(
                'Valid' => array(),
                'Error' => array()
            );

            // Error Possibilities
            $Error = array(
                "1" => "All Fields Required!",
                "2" => "Invalid Email!",
                "3" => "Wrong Email or Password!"
            );

            // Error Controller
            $err_data = array();

            // Error Checking
            foreach($post as $err)
            {
                if(!in_array("1", $err_data) && empty($err))
                {
                    array_push($err_data, "1");
                }
            }

            if(!empty($post['user_email']) && strpos($post['user_email'], '@') === false)
            {
                array_push($err_data, "2");
            }
            else
            {
                if(!empty($post['user_email']))
                {
                    $viewData['Valid']['user_email'] = $post['user_email'];
                }
            }

            if(!empty($viewData['Valid']) && !empty($post['user_password']))
            {
                // open DB connection
                $userRepo = new \app\repository\UserRepository();

                // check if user exists
                $user_email = $post['user_email'];
                $user_password = $post['user_password'];
                $user_check = $userRepo->selectOneByEmail($user_email);
                if(!empty($user_check))
                {
                    $user_check = $user_check[0];
                }
                if($user_check)
                {
                    $user_check = password_verify($user_password, $user_check['user_password']);
                }
                if(!$user_check)
                {
                    array_push($err_data, "3");
                }
            }

            // Store Errors to View Data
            foreach($err_data as $err)
            {
                array_push($viewData['Error'], $Error[$err]);
            }

            // if Form not fully correct pass Valid and Error Data
            if(!empty($err_data))
            {
                $parentObject->render_view("out:login", $viewData);
            }
            // else Set Session and Redirect
            else
            {
                // open DB connection
                $userRepo = new \app\repository\UserRepository();

                // get user id
                $user_email = $post['user_email'];
                $user_check = $userRepo->selectOneByEmail($user_email)[0];

                // Set Session
                $session->set('user_id', $user_check['user_id']);
                $session->set('user_name', $user_check['user_name']);

                // get Domain
                $domain = \app\super\Server::getDomain();

                // Redirect
                header("location: $domain/");
            }
        }
    }
}
