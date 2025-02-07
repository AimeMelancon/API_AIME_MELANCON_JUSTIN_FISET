<?php
require __DIR__ . "/../database.php";

$req = $pdo->prepare("SELECT * FROM coaches");
$req->execute();

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($rep) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    http_response_code(204);
    echo json_encode([
        "error_msg" => "Aucun coach n'a été trouvé."
    ]);
}

?>