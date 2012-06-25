<?php
$firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
$lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
$gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
$languages = isset($_POST["languages"]) ? $_POST["languages"] : "";
$work_fields = isset($_POST["work_fields"]) ? $_POST["work_fields"] : "";
$work_location = isset($_POST["work_location"]) ? $_POST["work_location"] : "";
$target_population = isset($_POST["target_population"]) ? $_POST["target_population"] : "";

$data = array(
    "firstname" => $firstname,
    "lastname" => $lastname,
    "gender" => $gender,
    "languages" => $languages,
    "work_fields" => $work_fields,
    "work_location" => $work_location,
    "target_population" => $target_population
);

require_once("api_helper.php");

echo json_encode(callapi("profile", "POST", $data));
?>