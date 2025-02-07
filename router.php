<?php
require __DIR__ . "/routes.php"; // Fichier qui contient get_routes();

$method = $_SERVER['REQUEST_METHOD'];
$routes = get_routes($method);

$request = $_SERVER['REQUEST_URI'];
// On récupère uniquement le chemin Ex http://localhost:8000/api/activities/random => /api/activities/random
$path = parse_url($request, PHP_URL_PATH);

$found = false; // On n'a pas encore trouvé de route correspondante initialement
foreach($routes as $route => $file) {
    if(preg_match("#^".$route."$#", $path)) { // On vérifie chaque chemin avec un regex
        if(file_exists(__DIR__ . $file)) {
            $found = true;
            require __DIR__ . $file; // On inclut/charge le fichier correspondant à la route
        } else {
            require __DIR__ . $routes["/404"]; // Si le fichier n'existe pas => 404.php
        }
        break; // On a trouvé une route correspondante, on arrête la boucle
    }
}

// Si aucune route ne correspond => 404.php
if(!$found) {
    require __DIR__ . $routes["/404"];
}
?>