<?php

require_once "db.php";
require_once "utils.php";

if (!isset($_GET["login"])) {
    show401AndExit();
}

$login = $_GET["login"];

//!!! Vérifier également le mot de passe dans la requete
$req = getPdo()->prepare("select id from users where nom = :login");
$res = $req->execute(array(":login" => $login));
$users = $req->fetchAll(PDO::FETCH_ASSOC);

//dans ma table users j'ai les colonnes: id, nom et current_token
if (count($users) == 1) {
    $token = generateRandomString(20);
    $id = $users[0]["id"];
    $req = getPdo()->prepare("update users set current_token = :token where id = :id");
    $req->execute(array(":id" => $id, ":token" => $token));
    echo "$token";
} else {
    header('HTTP/1.1 401 Unauthorized', true, 401);
}
