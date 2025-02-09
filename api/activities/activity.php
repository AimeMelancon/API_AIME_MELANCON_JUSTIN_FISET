<?php
require __DIR__ . "/../database.php";

$request = $_SERVER['REQUEST_URI'];
$id = basename($request);
if(filter_var($id, FILTER_VALIDATE_INT)) {
    $req = $pdo->prepare("SELECT a.*, c.name as coach_name, loc.name as location_name, loc.logo as location_logo
                        FROM activities a
                        JOIN coaches c ON a.coach_id = c.id
                        JOIN locations loc ON a.location_id = loc.id
                        WHERE a.id = :id
    ");
    $req->execute([
        "id" => $id
    ]);
    
    $rep = $req->fetchAll(PDO::FETCH_ASSOC);
    if($rep) {
        echo json_encode($rep, JSON_PRETTY_PRINT);
    } else {
        http_response_code(204);
        echo json_encode([
            "error_msg" => "Aucune activité ne possède cet id."
        ]);
    }
}

?>