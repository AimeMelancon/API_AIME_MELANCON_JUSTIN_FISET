<?php
// À TERMINER ****************************************** TODO: retirer cette ligne apres finalisation *********** ///

require __DIR__ . "/../database.php";

$request = $_SERVER['REQUEST_URI'];
$coach = isset($_GET['coach']) ? $_GET['coach'] : null;
$level = isset($_GET['level']) ? $_GET['level'] : null;
$location = isset($_GET['location']) ? $_GET['location'] : null;

$req = $pdo->prepare(
    "
    SELECT a.*
    FROM activities a
    JOIN coaches c ON a.coach_id = c.id
    JOIN levels l ON a.level_id = l.id
    JOIN locations loc ON a.location_id = loc.id
    WHERE (c.name = :coach OR :coach IS NULL)
    AND (l.name = :level OR :level IS NULL)
    AND (loc.name = :location OR :location IS NULL);
    "
);

$req->execute([
    "coach" => $coach,
    "level" => $level,
    "location" => $location
]);

$rep = $req->fetchAll(PDO::FETCH_ASSOC);
if($rep) {
    echo json_encode($rep, JSON_PRETTY_PRINT);
} else {
    http_response_code(204);
    echo json_encode([
        "error_msg" => "Aucune activité ne correspond à ces filtres."
    ]);
}

?>