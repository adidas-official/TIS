<?php 

require_once("functions.php");

if (permissions($_SESSION["role"]) != "all") {
    header("Location: ../index.php?error=90");
}

