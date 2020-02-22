<?php

// namespace
namespace app\model;

class AjaxModel
{
    public function getAllFiles()
    {
        // get Domain
        $domain = \app\super\Server::getDomain();

        // open DB connection
        $fileRepo = new \app\repository\FileRepository();
        $files = $fileRepo->selectAllFiles();

        // Output Holder
        $data = "";

        if($files) {
            foreach($files as $file) {
                $data .=
                    "<tr>" .
                    "<td>" . $file['file_name'] . "</td>" .
                    "<td class='preview_file' data-user_id='" . $file['user_id'] . "'" . "data-file_id='" . $file['file_id'] . "'" . "data-file_name='" . $file['file_name'] . "' " . "data-toggle='modal' " . "data-target='#preview_file' " . "><i class='fas fa-eye text-warning'></i></td>" .
                    "<td><a href='{$domain}/uploads/" . $file['user_id'] . $file['file_name'] . "' download>" . "<div><i class='fas fa-download text-primary'></i></div></a></td>" .
                    "<td class='preview_info' data-user_name='" . $file['user_name'] . "'" . "data-user_email='" . $file['user_email'] . "'" . "data-toggle='modal' " . "data-target='#preview_info' " . "><div class='info'><i class='fas fa-info-circle text-info'></div></i>" .
                    "</tr>";
            }
            echo $data;
        }
        else { echo 0; }
    }
}