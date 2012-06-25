<?php
    require_once("api_helper.php");
	
    $id = isset($_GET["id"]) ? $_GET["id"] : "";

    $ret = callapi("friendships/".$id, "PUT", array());
	print_r($ret);
    echo $ret["code"];
?>