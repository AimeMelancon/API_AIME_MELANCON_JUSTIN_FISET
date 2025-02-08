<?php 
require __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

if($data){

$req = $pdo ->prepare(
    "UPDATE activities SET   ");

}

?>