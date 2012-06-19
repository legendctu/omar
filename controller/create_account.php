<?php
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
$lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
$role = isset($_POST["role"]) ? $_POST["role"] : "";

$fields = array( 
    "email" => urlencode($email),
    "firstname" => urlencode($firstname),
    "lastname" => urlencode($lastname),
    "role" => urlencode($role)
);

$fields_string = "";
foreach($fields as $key=>$value)
{
    $fields_string .= $key.'='.$value.'&' ;
}
rtrim($fields_string ,'&');


$headers["Content-Type"] = "application/json";
$headers["Authorization"] = "Basic " . base64_encode($_COOKIE["OH_user"] . ":" . $_COOKIE["OH_pwd"]);

$headerArr = array();
foreach( $headers as $n => $v ) {
  $headerArr[] = $n .':' . $v;
}
 
ob_start();
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, "http://coconut.yach.me/admin/account/create");
curl_setopt ($ch, CURLOPT_HTTPHEADER , $headerArr);
curl_setopt( $ch, CURLOPT_HEADER, 1);

curl_setopt($ch, CURLOPT_POST,count($fields)) ;
curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string) ;
 
curl_exec($ch);
curl_close ($ch);
$out = ob_get_contents();
ob_clean();
echo $out;
?>