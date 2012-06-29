<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$query = isset($_GET["query"]) ? $_GET["query"] : "test";
	$type = isset($_GET["type"]) ? $_GET["type"] : "all";
    
	render_header('Search Result');
	render_nav('people_activity');
	
	$data = array('query' => $query);
	$ret = callapi("search", "GET", $data);
    $content = json_decode($ret['content'], true);
    $items = $content["result"];
    
    for ($i = 0; $i < count($items); $i++) {
        if ($items[$i]["result_type"] == "user") {
            if (($type == 'user') ||($type == 'all')) {
                $ret = callapi("profile/".$items[$i]["user_id"], "GET", array());
                $content = json_decode($ret['content'], true);
                $items[$i] = array_merge($items[$i], $content);
            } else {
                array_splice($items, $i, 1);
            }
        } else if ($items[$i]["result_type"] == "item") {
            if ($type == 'user') {
                array_splice($items, $i, 1);
            } else {
                $ret = callapi("items/".$items[$i]["item_id"], "GET", array());
                $content = json_decode($ret['content'], true);
                
                if (($content['category'] == $type) || ($type == 'all')) {
                    $items[$i] = array_merge($items[$i], $content);
                } else {
                    array_splice($items, $i, 1);
                }
            }
        }
    }
    $items_count = count($items);
	
	function render_item($result) { 
        $result_type = $result["result_type"];
        if ($result_type == "user") {
            $id = $result["user_id"];
        } else if ($result_type == "item") {
            $id = $result["item_id"];
        }
            
        if ($result_type == "user") {
            $uid = $id;
            $get_follow = callapi("friendships/".$uid, "GET", array());
            $action = ($get_follow['code'] == 404) ? 'follow' : 'unfollow';
        }
        else {
            $uid = $result['publisher_id'];
            $get_follow = callapi("watch/".$result['item_id'], "GET", array());
            $action = ($get_follow['code'] == 404) ? 'watch' : 'unwatch';
        }
        
        ?>
		<div class="mt10 p10 border-t">
			<a href="profile.php?id=<?php echo $uid;?>">
				<img class="avatar fl" src="<?= get_avatar_by_id($uid) ?>" uid="<?php echo $uid;?>" />
			</a>
            
            <?php if ($_COOKIE["OH_id"] != $id) { ?>
            <a name="watch_btn" action="<?php echo $action?>" iid="<?php echo $id?>" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">
                <?php 
                    if (($action == 'watch') || ($action == 'follow')) {
                        echo 'follow';
                    } else {
                        echo 'unfollow';
                    }
                ?>
            </a>
            <?php } ?>
            
            <div class="intro w500 ml90">
            <?php if ($result_type == "user") { ?>
				<span class="pl10 pr10 arial font24"><?= "People" ?></span>
				<a href="profile.php?id=<?= $uid ?>" class="arial blue font24 b"><?= $result["firstname"].' '.$result["lastname"] ?></a>
				<p class="pl10 verdana font18"><?= 'Email: '.$result['email'] ?></p>
                <p class="black arial font18 mt15"></p>
            <?php } else { ?>
                <span class="pl10 pr10 arial font24"><?= ucfirst($result["category"]) ?></span>
				<a href="show_item.php?id=<?= $result["item_id"] ?>" class="arial blue font24 b"><?= $result["title"] ?></a>
				<p class="pl10 verdana font18"><?= $result["description"] ?></p>
				<p class="black arial font18 mt15">
					<span class="tag">IT<a>star</a></span>
					<span class="tag">O<a>star</a></span>
					<span class="tag">Medicine<a>star</a></span>
					<span class="tag">Event<a>star</a></span>
				</p>
            <?php } ?>
			</div>
		</div><?php
	}
?>

<link style="text/css" href="../css/people_activity.css" rel="stylesheet"/>
<input type="hidden" id="cookie_self_id" value="<?php echo $_COOKIE["OH_id"];?>" />
<div id="content_wrap" class="wrap bg-white box-shadow">
<div class="p20">
	<div id="l_side" class="fl w250">
		<span class="font24 pink b ml20">Filter</span>
		<hr />
		<div class="ml15 mr15">
			<div class="pl20 white font18 button-bg r14 shadow">
			Field of work
			<span class="pr20 fr">plus</span>
			</div>
			<p class="black arial font18 mt15">
				<span class="tag">IT<a>X</a></span>
				<span class="tag">O<a>X</a></span>
			</p>
		</div>
		<hr class="mt15" />
		<div class="ml15 mr15">
			<div class="pl20 white font18 button-bg r14 shadow">
			Field of work
			<span class="pr20 fr">plus</span>
			</div>
			<p class="black arial font18 mt15">
				<span class="tag">IT<a>X</a></span>
				<span class="tag">O<a>X</a></span>
			</p>
		</div>
	</div>
	
	<div id="r_side" class="ml300">
        <p id="r_side_navi" class="pl20 font24 freshcolor">
            <span class="center mr15 b"><a href="<?= $type == "all" ? "#" : "search_result.php?query=".$query ?>" class="<?= $type == "all" ? "carmine" : "light-red" ?>">All</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "user" ? "#" : "search_result.php?type=user&query=".$query ?>" class="<?= $type == "user" ? "carmine" : "light-red" ?>">People</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "offer" ? "#" : "search_result.php?type=offer&query=".$query ?>" class="<?= $type == "offer" ? "carmine" : "light-red" ?>">Offers</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "need" ? "#" : "search_result.php?type=need&query=".$query ?>" class="<?= $type == "need" ? "carmine" : "light-red" ?>">Needs</a></span>
            <span class="center">/</span>
            <span class="center ml15 b"><a href="<?= $type == "event" ? "#" : "search_result.php?type=event&query=".$query ?>" class="<?= $type == "event" ? "carmine" : "light-red" ?>">Events</a></span>
        </p>

		<div>
		<?php
            if (!isset($_GET["query"]))
                echo '<div class="mt10 p10 border-t">Sorry, no query word.</div>';
			else if ($items_count == 0)
				echo '<div class="mt10 p10 border-t">Sorry, no result found.</div>';
			
            foreach($items as $value) {
                render_item($value);
            }
		?>
		</div>
	</div>
</div>
</div>

<div id="person_info" class="info-wrapper p5 absolute none">
    <div class="info-content p10"></div>
</div>

<script type="text/javascript">
    var info_cache = {};
    var self_id = $("#cookie_self_id").val();
    
    function displayInfo(uid){
        str = '<p><a class="blue b font16" href="profile.php?id=' + uid + '">' + info_cache[uid]["firstname"] + ' ' + info_cache[uid]["lastname"] + '</a> (' + info_cache[uid]["email"] + ')</p>';
        var w_loc = info_cache[uid]["work_location"] == "" ? "" : '@' + info_cache[uid]["work_location"];
        var str_c = w_loc != "" && info_cache[uid]["work_fields"] != "" ? ", " : "";
        str += '<p>' + w_loc + str_c + info_cache[uid]["work_fields"] + '</p>';
        if(self_id != uid){
            str += '<p class="mt6">';
            if(info_cache[uid]["is_followed"]){
                str += '<a id="follow_btn" f_type="unfollow" uid="' + uid + '" class="white font14 arial r14 button-bg pl20 pr20 b shadow">unfollow</a>';
            }else{
                str += '<a id="follow_btn" f_type="follow" uid="' + uid + '" class="white font14 arial r14 button-bg pl20 pr20 b shadow">follow</a>';
            }
            str += ' <span id="msgbox"></span></p>';
        }
        
        $("#person_info .info-content").html(str);
    }
    
    function watch_btn_click(e){
        var that = e.data.t;
        var type = that.attr("action");
        that.unbind("click");
        $.get("../controller/follow.php", 
            {
                "id": that.attr("iid"),
                "type": type
            },
            function(d) {
                that.bind("click", { t: that}, watch_btn_click);
                    switch (type) {
                        case 'watch':
                            that.attr("action", "unwatch");
                            that.html('unfollow');
                            break;
                        case 'unwatch':
                            that.attr("action", "watch");
                            that.html('follow');
                            break;
                        case 'follow':
                            that.attr("action", "unwatch");
                            that.html('unfollow');
                            break;
                        case 'unfollow':
                            that.attr("action", "watch");
                            that.html('follow');
                            break;
                }
            },
            "json"
        );
    }
    
    $(function(){
        $(".avatar").mouseover(function(){
            $("#person_info .info-content").html('<p class="b">loading, please wait¡­</p>');
            var info_off = $(this).offset();
            $("#person_info").css({"top": info_off.top, "left": info_off.left+$(this).width()}).show();
            var uid = $(this).attr("uid");
            if(typeof info_cache[ $(this).attr("uid") ] == "undefined"){
                $.post(
                    "../controller/profile.php",
                    {
                        "type": "get_profile",
                        "uid": uid
                    },
                    function(d){
                        for(var i in d["content"]){
                            if(d["content"][i] == null)
                                d["content"][i] = "";
                        }
                        
                        var str = "";
                        switch(d.code){
                            case 200:
                                info_cache[ d.content.id ] = d.content;
                                $.post(
                                    "../controller/profile.php",
                                    {
                                        "type": "get_follow_stat",
                                        "uid": uid
                                    },
                                    function(d){
                                        if(d.code == 404){
                                            info_cache[uid]["is_followed"] = false;
                                        }else{
                                            info_cache[uid]["is_followed"] = true;
                                        }
                                        displayInfo(uid);
                                    },
                                    "json"
                                );
                                break;
                            case 0:
                                str = '<p class="b">The connection is interrupted.</p>';
                                $("#person_info .info-content").html(str);
                                break;
                            
                        }
                    },
                    "json"
                );
            }else{
                displayInfo(uid);
            }
            
        }).mouseout(function(){
            $("#person_info").hide();
        });
        $("#person_info").mouseover(function(){
            $(this).show();
        }).mouseout(function(){
            $(this).hide();
        });
        
        //$("a[name='watch_btn']").bind("click", { t: $(this) }, watch_btn_click);
        $("a[name='watch_btn']").each(function(){
            var pp = $(this);
            $(this).bind("click", { t: pp }, watch_btn_click);
        });
        
        $("#follow_btn").live("click", function(){
            var type = $(this).attr("f_type"),
                uid = $(this).attr("uid");
            $("#msgbox").html("Processing¡­");
            $.getJSON(
                "../controller/follow.php",
                {
                    "type": type,
                    "id": uid
                },
                function(d){
                    if (d.code != 200){
                        $("#msgbox").html("Failed. Please try again.");
                    }else{
                        info_cache[uid]["is_followed"] = type == "follow" ? true : false;
                        displayInfo(uid);
                    }
                }
            );
        });
    });
</script>

<?php include("footer.php"); ?>