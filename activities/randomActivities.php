<?php
require __DIR__ . "/../database.php";

$req = $pdo->prepare("SELECT * FROM activities ORDER BY RAND() LIMIT 4");
$req->execute();

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($req) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    echo '{ "error": "Impossible de récuperer les activitées." }';
}

?>