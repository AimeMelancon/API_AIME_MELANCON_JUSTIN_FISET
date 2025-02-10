<?php 

require_once(__DIR__ . "/router.php");
require __DIR__ . "/api/activities/activity.php";

get("/api/activities/random", "/api/activities/randomActivities.php");
get("/api/activities/filter", "/api/activities/filterActivities.php");

post("/api/activities", function() {
    Activity::addActivity();
});

put('/api/activities/$id', function($id) {
    Activity::updateActivity($id);
});

get('/api/activities/$id', function($id) {
    Activity::getActivity($id);
});

get("/api/coaches", "/api/coaches/coaches.php");
get("/api/locations", "/api/locations/locations.php");
get("/api/levels", "/api/levels/levels.php");

any("/404", "/404.php");
?>