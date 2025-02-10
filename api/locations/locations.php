<?php
require __DIR__ . "/../database.php";

header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json; charset=utf-8');  

$req = $pdo->prepare("SELECT * FROM locations");
$req->execute();

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($rep) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    http_response_code(204);
    echo json_encode([
        "error_msg" => "Aucune localisation n'a été trouvé."
    ]);
}

?>