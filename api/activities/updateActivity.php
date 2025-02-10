<?php
require __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    try {
        $req = $pdo->prepare(
            "UPDATE activities 
            SET   name = :name, description = :description, level_id = :level_id, coach_id = :coach_id, schedule_day = :schedule_day , schedule_time =:schedule_time, location_id = :location_id
            WHERE activities.id = :id"
        );

        $req->execute([
            "name" => $data["name"],
            "description" => $data["description"],
            "level_id" => $data["level_id"],
            "coach_id" => $data["coach_id"],
            "schedule_day"=> $data["schedule_day"],
            "schedule_time"=> $data["schedule_time"],
            "location_id" => $data["location_id"],
            "id" => $data["id"],
        ]);

        $rep = $req->fetchAll(PDO::FETCH_ASSOC);
        if($rep){
            echo json_encode($rep, JSON_PRETTY_PRINT);
        }else{
            http_response_code(409);
            echo json_encode([
                "error_msg" => "Une activité avec les mêmes spécifications existe déjà."
            ]);
        }

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(    [
            "error_msg"=>"L'id de l'activité saisie n'est pas valide."
        ]);
    
    }
} else {
    http_response_code(400);
    echo json_encode( [
       "error_msg"=> "JSON invalide"
        ]);
}
?>
