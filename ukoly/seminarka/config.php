<?php 

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strint_mode", 1);

include_once("errors.php");
include_once("status.php");

session_set_cookie_params(["livetime"=> 1800, "domain" => "localhost", "path" => "/", "secure" => true, "httponly" => true]);

session_start();

if (!isset($_SESSION["last_regen"])) {

    $_SESSION["last_regen"] = time();
    session_regenerate_id(true);

} else {
    $interval = 30 * 60;

    if ($interval + $_SESSION["last_regen"] <= time() ) {
        $_SESSION["last_regen"] = time();
        session_regenerate_id(true);
    }
}

