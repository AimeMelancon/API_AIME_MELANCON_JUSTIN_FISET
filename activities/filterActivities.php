<?php

require __DIR__ . "/../database.php";

$request = $_SERVER['REQUEST_URI'];
$coach = (isset($_GET["coach"]) && strlen($_GET["coach"])) ? $_GET["coach"] : null;
$level = (isset($_GET["level"]) && isset($_GET["level"])) ? $_GET["level"] : null;
$location = (isset($_GET["location"]) && isset($_GET["location"])) ? $_GET["location"] : null;

$demande = 
    "
    SELECT a.*, c.name as coach_name, loc.name as location_name
    FROM activities a
    JOIN coaches c ON a.coach_id = c.id
    JOIN locations loc ON a.location_id = loc.id
    WHERE 1=1
    "; // Le WHERE 1=1 permet de ne pas avoir à gérer le premier AND dans la requête

// CONSTRUSTION DE LA REQUETE SQL ET DES PARAMS À ENVOYER -----------------------------------
$params = [];
if($coach) {
    $demande .= " AND c.name = :coach ";
    $params["coach"] = $coach;
}
if ($level) {
    $demande .= " AND level_id = :level";
    $params["level"] = $level;
}
if ($location) {
    $demande .= " AND loc.name = :location";
    $params["location"] = $location;
}

$req = $pdo->prepare($demande.";");
$req->execute($params);
$rep = $req->fetchAll(PDO::FETCH_ASSOC);

if($rep) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    http_response_code(204);
    echo json_encode([
        "error_msg" => "Aucune activité ne correspond à ces filtres."
    ]);
}

?>