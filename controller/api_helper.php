<?php
function callapi($url, $type = "POST", $data){
    $type = strtoupper($type);
    
    ob_start();
    $ch = curl_init();
    
    if($type == "POST"){
        $headers["Content-Type"] = "application/json";
        $headers["Authorization"] = "Basic " . base64_encode($_COOKIE["OH_user"] . ":" . $_COOKIE["OH_pwd"]);
        $headerArr = array();
        foreach( $headers as $n => $v ){
            $headerArr[] = $n .': ' . $v;
        }
        curl_setopt($ch, CURLOPT_URL, "http://coconut.yach.me/{$url}");
        curl_setopt ($ch, CURLOPT_HTTPHEADERS, $headerArr);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }else{
        $url .= "?";
        foreach($data as $k => $v){
            $url .= "{$k}={$v}&";
        }
        curl_setopt($ch, CURLOPT_URL, "http://coconut.yach.me/{$url}");
    }
    
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