<?php

function isValid(...$values)
{
    foreach ($values as $value) {
        if (isset($value)) {
            if (is_string($value) && empty(trim($value))) {

                http_response_code(400);
                echo json_encode([
                    "status" => "JSON invalide, vous devez fournir une activité valide au format JSON."
                ]);
                return false;
            }
        }
    }
    return true;
}

?>