<?php

include_once "config/index.php";
require_once "vendor/autoload.php";

$studentDelete = $repository->delete(2);
var_dump($studentDelete);
