<?php

include_once "db.php";
include_once "utils.php";

$id = getUserIdFromToken();

if ($id === false) {
    show401AndExit();
}

header('Content-type: application/json');
$results = getAllBornes();
$json = json_encode($results);

echo $json;
