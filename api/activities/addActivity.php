<?php
require __DIR__ . "/../database.php";

$json = (isset($_POST["data"]) && strlen($_POST("data")) > 0) ? $_POST("data") : null;
$data = null;
if($json) {
    $data = json_decode($json, true);
}

if($data) {
    print_r($data); // TODO: REMOVE

    $req = $pdo->prepare("INSERT INTO activities (name, description, level_id, coach_id, location_id) 
                         VALUES (:name, :description, :level_id, :coach_id, :location_id)");
    $req->execute([
        "name" => $data["name"],
        "description" => $data["description"],
        "level_id" => $data["level_id"],
        "coach_id" => $data["coach_id"],
        "location_id" => $data["location_id"]
    ]);
    
    $rep = $req->fetchAll(PDO::FETCH_ASSOC); 
    if($rep) {
        echo json_encode($rep, JSON_PRETTY_PRINT);
    } else {
        http_response_code(409);
        echo json_encode([
            "error_msg" => "Une activité avec les mêmes spécifications existe déjà."
        ]);
    }
} else {
    http_response_code(400);
        echo json_encode([
            "error_msg" => "JSON Invalide."
        ]);
}

?>