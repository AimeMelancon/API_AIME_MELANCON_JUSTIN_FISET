<?php
require __DIR__ . "/../database.php";

$request = $_SERVER['REQUEST_URI'];
$id = basename($request);

$req = $pdo->prepare("SELECT * FROM activities WHERE id = :id");
$req->execute([
    "id" => $id
]);

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($req) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    echo '{ "error": "Impossible de récuperer les activitées." }';
}

?>