<?php
require __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {

    $req = $pdo->prepare(
        "UPDATE activities 
            SET   name = :name, description = :description, level_id = :level_id, coach_id = :coach_id, location_id = :location_id
            WHERE activities.id = :activities_id"
    );

    $req->execute([
        "name" => $data["name"],
        "description" => $data["description"],
        "level_id" => $data["level_id"],
        "coach_id" => $data["coach_id"],
        "location_id" => $data["location_id"],
        "activities_id"=> $data["activities_id"],
    ]);

    $rep = $req->fetchAll(PDO::FETCH_ASSOC); 

    

}
