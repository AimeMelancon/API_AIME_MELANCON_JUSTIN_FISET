<?php

$req = $pdo->prepare("SELECT * FROM activities ORDER BY RAND() LIMIT 4");
$req->execute();

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($req) {
    echo json_encode($rep);
} else {
    echo '{ "error": "Impossible de récuperer les activitées." }';
}

?>