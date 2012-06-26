<?php
    require_once("api_helper.php");
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	$type = isset($_GET["type"]) ? $_GET["type"] : "";
    switch($type){
        case "follow":
            $ret = callapi("friendships/".$id, "PUT");
            break;
        case "unfollow":
            $ret = callapi("friendships/".$id, "DELETE");
            break;
        case "watch":
            $ret = callapi("watch/".$id, "PUT");
            break;
        case "unwatch":
            $ret = callapi("watch/".$id, "DELETE");
            break;
    }
    
    echo json_encode($ret);
?>