<?php
require __DIR__ . "/../database.php";

class Activity
{
    static function getActivity($id)
    {
        global $pdo;

        header('Access-Control-Allow-Origin: *');  
        header('Content-Type: application/json; charset=utf-8');  

        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $req = $pdo->prepare("
                SELECT a.*, c.name as coach_name, loc.name as location_name, loc.logo as location_logo, loc.id as location_id
                FROM activities a
                JOIN coaches c ON a.coach_id = c.id
                JOIN locations loc ON a.location_id = loc.id
                WHERE a.id = :id
            ");
            $req->execute([
                "id" => $id
            ]);

            $rep = $req->fetchAll(PDO::FETCH_ASSOC);
            if ($rep) {
                echo json_encode($rep, JSON_PRETTY_PRINT);
            } else {
                http_response_code(204);
                echo json_encode([
                    "error_msg" => "Aucune activité ne possède cet id."
                ]);
            }
        }
    }

    static function updateActivity($id)
    {
        global $pdo;
        
        header('Access-Control-Allow-Origin: *');  
        header('Content-Type: application/json; charset=utf-8');  
        
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
                    "schedule_day" => $data["schedule_day"],
                    "schedule_time" => $data["schedule_time"],
                    "location_id" => $data["location_id"],
                    "id" => $data["id"],
                ]);

                $rep = $req->fetchAll(PDO::FETCH_ASSOC);
                if ($rep) {
                    echo json_encode($rep, JSON_PRETTY_PRINT);
                } else {
                    http_response_code(409);
                    echo json_encode([
                        "error_msg" => "Une activité avec les mêmes spécifications existe déjà."
                    ]);
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    "error_msg" => "L'id de l'activité saisie n'est pas valide."
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                "error_msg" => "JSON invalide"
            ]);
        }
    }

    static function addActivity()
    {
        global $pdo;

        header('Access-Control-Allow-Origin: *');  
        header('Content-Type: application/json; charset=utf-8');  

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
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
            if ($rep) {
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
    }
}
