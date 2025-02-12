<?php
require __DIR__ . "/../database.php";
require __DIR__ . "/../../utils.php";

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
                    "status" => "Aucune activité ne possède cet id."
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

        if ($data && isValid($data["name"], $data["description"], $data["image"], $data["level_id"], $data["coach_id"], $data["schedule_day"], $data["schedule_time"], $data["location_id"])) {
            try {
                if (filter_var($id, FILTER_VALIDATE_INT)) {
                    //On insère dans l'activité sélectionné les nouvelles données voulues
                    $req = $pdo->prepare(
                        "
                        UPDATE activities 
                        SET   name = :name, description = :description,image = :image, level_id = :level_id, coach_id = :coach_id,
                        schedule_day = :schedule_day , schedule_time =:schedule_time, location_id = :location_id
                        WHERE activities.id = :id
                        "
                    );

                    $req->execute([
                        "name" => htmlspecialchars($data["name"]),
                        "description" => htmlspecialchars($data["description"]),
                        "image" => htmlspecialchars($data["image"]),
                        "level_id" => htmlspecialchars($data["level_id"]),
                        "coach_id" => htmlspecialchars($data["coach_id"]),
                        "schedule_day" => htmlspecialchars($data["schedule_day"]),
                        "schedule_time" => htmlspecialchars($data["schedule_time"]),
                        "location_id" => htmlspecialchars($data["location_id"]),
                        "id" => htmlspecialchars($id),
                    ]);

                    if ($req->rowCount() > 0) {
                        http_response_code(200);
                        echo json_encode([
                            "status" => "Activité modifié avec succès!"
                        ]);
                    } else {
                        http_response_code(404);
                        echo json_encode([
                            "status" => "Echec de la modification d'une activité. Activité introuvable ou champs inchangés."
                        ]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["status" => "L'id de l'activité n'est pas un id valide."]);
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    "status" => "L'id de l'activité saisie n'est pas valide."
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                "status" => "JSON invalide, vous devez fournir une activité valide au format JSON."
            ]);
        }
    }

    static function addActivity()
    {
        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if ($data && isValid($data["name"], $data["description"], $data["image"], $data["level_id"], $data["coach_id"], $data["schedule_day"], $data["schedule_time"], $data["location_id"])) {
                $req = $pdo->prepare("INSERT INTO activities (name, description, image, level_id, coach_id, schedule_day, schedule_time, location_id) 
                                     VALUES (:name, :description, :image, :level_id, :coach_id, :schedule_day, :schedule_time, :location_id)");

                $success = $req->execute([
                    "name" => htmlspecialchars($data["name"]),
                    "description" => htmlspecialchars($data["description"]),
                    "image" => htmlspecialchars($data["image"]),
                    "level_id" => htmlspecialchars($data["level_id"]),
                    "coach_id" => htmlspecialchars($data["coach_id"]),
                    "schedule_day" => htmlspecialchars($data["schedule_day"]),
                    "schedule_time" => htmlspecialchars($data["schedule_time"]),
                    "location_id" => htmlspecialchars($data["location_id"])
                ]);

                if ($success) {
                    http_response_code(200);
                    echo json_encode([
                        "status" => "Nouvelle activité bien crée!"
                    ]);
                } else {
                    http_response_code(409);
                    echo json_encode([
                        "status" => "Echec de l'ajout d'une nouvelle activité."
                    ]);
                }
            } else {
                http_response_code(400);
                echo json_encode([
                    "status" => "Vous devez fournir une activité dans un format json valide."
                ]);
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "status" => $e->getMessage()
            ]);
        }
    }


    static function isIdActivityValid($id){

        global $pdo;

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try{
            $req= $pdo->prepare('SELECT id
            FROM activities
            WHERE id = :id');

            $req->execute([
                'id'=> $id
             ]);

             $rep =$req->fetch(PDO::FETCH_ASSOC);

             if($rep){
                http_response_code(200);
                    echo json_encode([
                        "status" => "Cette id existe bel et bien dans la base de donnée !"
                    ]);
             }else{
                http_response_code(404);
                echo json_encode(["status"=>"L'id saisit est introuvable."]);
             }


        }catch(Exception $e){
            http_response_code(404);
            echo json_encode(["status"=> $e->getMessage()]);
        }

    }
}

?>
