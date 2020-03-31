<?php

require_once "db_utils.php";
require_once "utils.php";

$id = getUserIdFromToken();

if ($id === false) {
    show401AndExit();
}

header('Content-type: application/json');
$result = getUserInfoById($id);
if ($result == false) {
    show500AndExit();
}
$json = json_encode($result);
echo $json;
