<?php 
$request = $_SERVER['REQUEST_URI'];

if($_SERVER["REQUEST_METHOD"] == "GET") {
    switch ($request) {
        case "/api/activities/random" :
            require __DIR__ . "/random.php";
            break;
        case "/api/activities/filter" :
            require __DIR__ . "/filters.php";
        default:
            // Gestion des pages non trouvées
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }
}

?>