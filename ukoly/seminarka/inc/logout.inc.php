<?php 

include_once("../config.php");

if (isset($_SESSION["userid"])) {
    session_destroy();
    header("Location: ../index.php");
}