<?php

require __DIR__ . "/../database.php";

header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json; charset=utf-8');  

$coach = (isset($_GET["coach"]) && strlen($_GET["coach"])) ? $_GET["coach"] : null;
$level = (isset($_GET["level"]) && isset($_GET["level"])) ? $_GET["level"] : null;
$location = (isset($_GET["location"]) && isset($_GET["location"])) ? $_GET["location"] : null;

$demande = 
    "
    SELECT a.*, c.name as coach_name, loc.name as location_name, loc.logo as location_logo
    FROM activities a
    JOIN coaches c ON a.coach_id = c.id
    JOIN locations loc ON a.location_id = loc.id
    WHERE 1=1
    "; // Le WHERE 1=1 permet de ne pas avoir à gérer le premier AND dans la requête

// CONSTRUSTION DE LA REQUETE SQL ET DES PARAMS À ENVOYER -----------------------------------
$params = [];
if($coach) {
    $demande .= " AND c.name = :coach ";
    $params["coach"] = htmlspecialchars($coach);
}
if ($level) {
    $demande .= " AND level_id = :level";
    $params["level"] = htmlspecialchars($level);
}
if ($location) {
    $demande .= " AND loc.name = :location";
    $params["location"] = htmlspecialchars($location);
}

$req = $pdo->prepare($demande);
$req->execute($params);
$rep = $req->fetchAll(PDO::FETCH_ASSOC);

if($rep) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    http_response_code(204);
    echo json_encode([
        "status" => "Aucune activité ne correspond à ces filtres."
    ]);
}

?>