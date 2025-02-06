<?php 
http_response_code(404);
echo json_encode([
    "error_msg" => "Impossible de trouver la page demandée."
]);
?>