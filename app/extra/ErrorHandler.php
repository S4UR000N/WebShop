<?php

// namespace
namespace app\extra;


class ErrorHandler
{
    public static function call401($cond)
    {
        if($cond) {
            require BP . "public/errors/401.php";
            die();
        }
    }

    public static function call404()
    {
        return require BP . "public/errors/404.php";
    }

    public static function call500()
    {
        return require BP . "public/errors/500.php";
    }

    public static function saveInErrorsLog($e)
    {
        // get and arrange browser data
        $server = new \app\super\Server();
        $server = $server->getServer();
        $isUserLogdIn = (\app\extra\Request::isLogdIn()) ? "true" : "false";
        $getBrowserURL = $root = (!empty($server['HTTPS']) ? 'https' : 'http') . '://' . $server['HTTP_HOST'] . '/';
        $browser = get_browser(null, true);
        $browserArrangedData = "";
        foreach ($browser as $const => $data) {
            $browserArrangedData .= $const . "::" . $data . "\n";
        }

        // set data and arrange all data
        $data .= "Date is: " . date("Y.m.d./H:i:s") . "\n";
        $data .= "User is loged in: " . $isUserLogdIn . "\n";
        $data .= "URL: " . $getBrowserURL . "\n";
        $data .= "======Browser info======\n";
        $data .= $browserArrangedData;
        $data .= "======Exception info======\n";
        $data .= $e . "\n\n\n";

        // send data to error.log
        error_log($data, 3, BP . "public/var/tmp/errors.log");

    }
}
