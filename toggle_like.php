<?php

require_once "db_utils.php";
require_once "utils.php";

if (!isset($_POST["id_photo"])) {
    show401AndExit();
}

$id_photo = $_POST["id_photo"];

$result = toggleLikeForPhoto($id_photo);

echo $result;
