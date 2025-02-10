<?php
require __DIR__ . "/../database.php";

header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json; charset=utf-8');  

$req = $pdo->prepare("SELECT * FROM activities ORDER BY RAND() LIMIT 4");
$req->execute();

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($rep) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        "error_msg" => "Impossible de récuperer les activitées."
    ]);
}

?>