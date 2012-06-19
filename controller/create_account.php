<?php
include_once("api_helper.php");

$email = isset($_POST["email"]) ? $_POST["email"] : "";
$firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
$lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
$role = isset($_POST["role"]) ? $_POST["role"] : "";

$data = array( 
    "email" => $email,
    "firstname" => $firstname,
    "lastname" => $lastname,
    "role" => $role
);

echo json_encode(callapi("admin/account/create", "POST", $data));


?>