<?php

require_once "db_utils.php";
require_once "utils.php";

if (!isset($_GET["code"])) {
    show401AndExit();
}

$code = $_GET["code"];

header('Content-type: application/json');
$results = getPhotosByCode($code);
$json = json_encode($results);

echo $json;
