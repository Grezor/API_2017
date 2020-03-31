<?php

require_once "db.php";

/**
 * Trouve un utilisateur à partir de son token
 *
 * @param [string] $token
 * @return l'identifiant de l'utilisateur ou false
 */
function findUserIdByToken($token)
{
    $pdo = getPdo();
    $req = $pdo->prepare("select id from users where current_token = :token");
    $res = $req->execute(array(":token" => $token));
    $ids = $req->fetchAll(PDO::FETCH_ASSOC);
    if (count($ids) == 1) {
        return $ids[0]["id"];
    } else {
        return false;
    }
}

function getAllBornes()
{
    $statement = getPdo()->prepare("SELECT * FROM bornes");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUserInfoById($id)
{
    $statement = getPdo()->prepare("SELECT * FROM users where id = :id");
    $statement->execute(array(":id" => $id));
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($results) == 1) {
        return $results[0];
    }
    return false;
}

function getPhotosByCode($code)
{
    $req = <<<EOD
    SELECT p.id, estAime, url, date_prise FROM photos p
    INNER JOIN reservations AS r ON p.id_reservation = r.id
    where r.code_evenement = :code
EOD;

    $statement = getPdo()->prepare($req);
    $statement->execute(array(":code" => $code));
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getIsPhotoLikedById($id_photo)
{
    $req = <<<NANI
SELECT estAime
FROM photos
WHERE id = :id
NANI;

    $statement = getPdo()->prepare($req);
    $statement->execute(array(":id" => $id_photo));

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result["estAime"];
}

function toggleLikeForPhoto($id_photo)
{
    $isLiked = getIsPhotoLikedById($id_photo);
    $isLiked = $isLiked == 0 ? 1 : 0;

    /*if($isLiked == 0){
    return 1;
    }else{
    return 0;
    }*/

    $req = <<<EOD
UPDATE photos
SET estAime = :isLiked
WHERE id = :id
EOD;

    $statement = getPdo()->prepare($req);
    $statement->execute(array(":isLiked" => $isLiked, ":id" => $id_photo));
    return $isLiked;
}
