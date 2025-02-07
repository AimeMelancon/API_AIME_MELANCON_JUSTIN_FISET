<?php 

// Spécification de chacunes des routes pour les différents fichiers php en fonction de la méthode HTTP (GET, POST, PUT, DELETE)
// chaque clé est un regex et chaque valeur est le chemin du fichier php correspondant qui sera chargé
function get_routes($method) {
    if($method == "GET") {
        return [
            "/api/activities/random" => "/api/activities/randomActivities.php",
            "/api/activities/filter" => "/api/activities/filterActivities.php",
            "/api/activities/([0-9]+)" => "/api/activities/activity.php",
            "/404" => "/404.php",
        ];
    } else if($method == "POST") {
        return [
            "/api/activities" => "/api/activities/addActivity.php",
            "/404" => "/404.php",
        ];
    } else if($method == "PUT") {
        return [
            "/api/activities/([0-9]+)" => "/api/activities/updateActivity.php",
            "/404" => "/404.php",
        ];
    }
}

?>