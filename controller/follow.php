<?php
    require_once("api_helper.php");
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	$type = isset($_GET["type"]) ? $_GET["type"] : "";
    if($type == "follow"){
        $ret = callapi("friendships/".$id, "PUT");
    }else{
        $ret = callapi("friendships/".$id, "DELETE");
    }
    echo json_encode($ret);
?>