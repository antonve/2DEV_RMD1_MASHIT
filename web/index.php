<?php

// index.php - front controller
// By Anton Van Eechaute

error_reporting(E_ALL);
ini_set('display_errors', '1');

$project_dir = __DIR__ . "/../";

include_once($project_dir . 'app/bootstrap.php');
