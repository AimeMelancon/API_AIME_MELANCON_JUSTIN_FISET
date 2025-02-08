<?php
require __DIR__ . "/../database.php";

$request = $_SERVER['REQUEST_URI'];
$id = basename($request);
if(filter_var($id, FILTER_VALIDATE_INT)) {
    $req = $pdo->prepare("SELECT * FROM activities WHERE id = :id");
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