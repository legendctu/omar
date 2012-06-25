<?php
function callapi($url, $type = "POST", $data = array(), $tmp_user = "", $tmp_pwd = ""){
    $type = strtoupper($type);
    
    ob_start();
    $ch = curl_init();
    
    $headers = array();
    $auth_str = "";
    
    if(isset($_COOKIE["OH_user"]) && isset($_COOKIE["OH_pwd"])){
        $auth_str = $_COOKIE["OH_user"] . ":" . $_COOKIE["OH_pwd"];
    }else{
        $auth_str = $tmp_user . ":" . $tmp_pwd;
    }

    $headers["Authorization"] = "Basic " . base64_encode($auth_str);
    
    switch($type){
        case "POST":
            $headers["Content-Type"] = "application/json";
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case "GET":
            if(!empty($data)){
                $url .= "?";
                foreach($data as $k => $v){
                    $url .= "{$k}={$v}&";
                }
            }
            break;
        case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'DELETE');
            break;
        case "PUT":
            curl_setopt($ch, CURLOPT_PUT,true);
            break;
        default:
            return array(
                "code" => -1,
                "content" => "Method Error!"
            );
            break;
    }

    $headerArr = array();
    foreach( $headers as $n => $v ){
        $headerArr[] = $n .': ' . $v;
    }
    curl_setopt($ch, CURLOPT_URL, "http://coconut.yach.me:58000/{$url}");
    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headerArr);
    
    $result = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    curl_close ($ch);
    $out = ob_get_contents();
    ob_clean();
    
    return array(
        "code" => $code,
        "content" => $out
    );
}
?>