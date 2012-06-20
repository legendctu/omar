<?php
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$pwd = isset($_POST["pwd"]) ? $_POST["pwd"] : "";
$type = isset($_POST["type"]) ? $_POST["type"] : "";

require_once("api_helper.php");

if($type == "activate"){
    $data = array(
        "email" => $email
    );
    echo json_encode(callapi("account/send_verification_email", "POST", $data));
}else{
    if(isset($_COOKIE["OH_user"]) || isset($_COOKIE["OH_pwd"])){
        setcookie("OH_user", "", time()-3600);
        setcookie("OH_pwd", "", time()-3600);
    }
    setcookie("OH_user", $email);
    setcookie("OH_pwd", $pwd);
    
    echo json_encode(callapi("account/verify_credentials", "GET"));
}



?>