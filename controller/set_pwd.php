<?php
    require_once("api_helper.php");
    
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $vcode = isset($_POST["verification_code"]) ? $_POST["verification_code"] : "";
    $pwd = isset($_POST["password"]) ? $_POST["password"] : "";
    
    $data = array(
        "email" => $email,
        "verification_code" => $vcode,
        "password" => $pwd
    );
    
    echo json_encode(callapi("account/activate", "POST", $data));
?>