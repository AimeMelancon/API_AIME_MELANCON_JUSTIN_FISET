<?php 

// Spécification de chacunes des routes pour les différents fichiers php en fonction de la méthode HTTP (GET, POST, PUT, DELETE)
// chaque clé est un regex et chaque valeur est le chemin du fichier php correspondant qui sera chargé
$routes = [
    "GET" => [
        "/index/?" => "/public/index.php",
        "/formulaireActivite/?" => "/public/formulaireActivite.php",
        "/listeActivite/?" => "/public/listeActivite.php",
        "/api/activities/random/?" => "/api/activities/randomActivities.php",
        "/api/activities/filter/?" => "/api/activities/filterActivities.php",
        "/api/activities/([0-9]+/?)" => "/api/activities/activity.php",
        "/api/coaches/?" => "/api/coaches/coaches.php",
        "/api/locations/?" => "/api/locations/locations.php",
        "/api/levels/?" => "/api/levels/levels.php",
        "/404" => "/404.php",
    ],
    "POST" => [
        "/api/activities/?" => "/api/activities/addActivity.php",
        "/404" => "/404.php",
    ],
    "PUT" => [
        "/api/activities/([0-9]+)" => "/api/activities/updateActivity.php",
        "/404" => "/404.php",
    ],
];

function get_routes($method) {
    global $routes;
    return $routes[$method] ?? [];
}

?>