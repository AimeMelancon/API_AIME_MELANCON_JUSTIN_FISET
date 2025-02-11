<?php 
http_response_code(404);
echo json_encode([
    "status" => "Impossible de trouver la page demandée."
]);
?>