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
    $res = callapi("account/verify_credentials", "GET", array(), $email, $pwd);
    if($res["code"] == 200){
        setcookie("OH_user", $email, 0, '/');
        setcookie("OH_pwd", $pwd, 0, '/');
        $get_uid_res = callapi("profile", "GET", array(), $email, $pwd);
        $get_uid_res = json_decode($get_uid_res["content"]);
        setcookie("OH_id", $get_uid_res->id, 0, '/');
    }
    echo json_encode($res);
}
?>