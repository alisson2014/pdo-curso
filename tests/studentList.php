<?php

include_once "vendor/autoload.php";
require_once "config/index.php";

$studentList = $repository->allStudents();

var_dump($studentList);
