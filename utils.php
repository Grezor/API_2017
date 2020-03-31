<?php

require_once "db_utils.php";

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function show401AndExit()
{
    header('HTTP/1.1 401 Unauthorized', true, 401);
    exit(-1);
}

function show500AndExit()
{
    header('HTTP/1.1 error 500', true, 500);
    exit(-1);
}

/**
 * Récupère le token transmis dans la requête
 *
 * @return le token si trouvé dans le get ou post, sinon false
 */
function getTokenFromRequest()
{
    if (isset($_GET["token"])) {
        return $_GET["token"];
    }
    if (isset($_POST["token"])) {
        return $_POST["token"];
    }
    return false;
}

/**
 * Undocumented function
 * Récupère l'id de l'utilisateur si son token est trouvé en bdd sinon false
 * @param [string] $token
 * @return l'identifiant de l'utilisateur si token valide, sinon false
 */
function getUserIdFromToken()
{
    $token = getTokenFromRequest();
    if ($token === false) {
        return false;
    }
    return findUserIdByToken($token);
}
