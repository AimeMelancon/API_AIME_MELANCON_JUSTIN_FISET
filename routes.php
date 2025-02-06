<?php 
$request = $_SERVER['REQUEST_URI'];

if($_SERVER["REQUEST_METHOD"] == "GET") {
    switch ($request) {
        case "/api/activities/random" :
            require __DIR__ . "/activities/randomActivities.php";
            break;
        case "/api/activities/filter" :
            require __DIR__ . "/activities/filteredActivity.php";
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/404.php';
            break;
    }
}

?>