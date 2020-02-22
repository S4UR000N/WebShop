<?php

// namespace
namespace app\model;

class RegistrationModel extends UserModel
{
    public function registration(\app\controller\UserController $parentObject)
    {
        //on GET request execute if | on POST request excecute else
        if(!\app\extra\Request::requestMethod())
        {
            $parentObject->render_view("out:registration");
        }
        else
        {
            // store $post
            $post = new \app\super\Post();
            $post = $post->getPost();

            // Final View Data
            $viewData = array(
                'Valid' => array(),
                'Error' => array()
            );

            // Partialy Valid Data Requires Compact
            $Valid = array(
                "user_name" => "",
                "user_email" => ""
            );

            // Error Possibilities
            $Error = array(
                "1" => "All Fields Required!",
                "2" => "Invalid Email!",
                "3" => "Name is in Use!",
                "4" => "Email is in Use!",
                "5" => "Invalid Passwords!"
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
                // open DB connection
                $userRepo = new \app\repository\UserRepository();

                // check if name & email aleready exist
                $name_check = $userRepo->selectOneByName($post['user_name']);
                $email_check = $userRepo->selectOneByEmail($post['user_email']);
                if($name_check)
                {
                    array_push($err_data, "3");
                }
                else
                {
                    $Valid['user_name'] = $post['user_name'];
                }

                if($email_check)
                {
                    array_push($err_data, "4");
                }
                else
                {
                    $Valid['user_email'] = $post['user_email'];
                }
            }

            if(!empty($post['user_password']) && $post['user_password'] !== $post['user_confirm_password'])
            {
                array_push($err_data, "5");
            }

            // Store Errors to View Data
            foreach($err_data as $err)
            {
                array_push($viewData['Error'], $Error[$err]);
            }

            // Store All Valids to View Data
            foreach($Valid as $key => $val)
            {
                if(!empty($val))
                {
                    $viewData['Valid'][$key] = $val;
                }
            }

            // if Form not fully correct pass Valid and Error Data
            if(!empty($err_data))
            {
                $parentObject->render_view("out:registration", $viewData);
            }

            // else Save User & redirect
            else
            {
                // open DB connection
                $userRepo = new \app\repository\UserRepository();

                // Save User
                $user = new \app\model\UserModel();
                $user->setUserName($post['user_name']);
                $user->setUserEmail($post['user_email']);
                $user->setUserPassword(password_hash($post['user_password'], PASSWORD_BCRYPT));
                $userRepo->saveUser($user);

                // get Domain
                $domain = \app\super\Server::getDomain();

                // Redirect
                header("location: $domain/user_login");
            }
        }
    }
}
