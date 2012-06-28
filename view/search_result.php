<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$query = isset($_GET["query"]) ? $_GET["query"] : "test";
	$type = isset($_GET["type"]) ? $_GET["type"] : "all";
    
	render_header('People & Activity');
	render_nav('people_activity');
	
	//$data = array('query' => $query);
	//$ret = callapi("search", "GET", $data);
    //print_r($ret);
	//$items = json_decode($ret['result'], true);
	//print_r($items);
	
    //$ret = result_type
	//$items_count = json_decode($ret['content'], true);
	
	function render_item($result_type, $id) { 
        if ($result_type == "user") {
            $uid = $id;
            $ret = callapi("profile/".$id, "GET", array());
            $user = json_decode($ret['content'], true);
            $get_follow = callapi("friendships/".$uid, "GET", array());
            $action = ($get_follow['code'] == 404) ? 'follow' : 'unfollow';
        }
        else {
            $ret = callapi("items/".$id, "GET", array());
            $item = json_decode($ret['content'], true);
            $uid = $item['publisher_id'];
            $get_follow = callapi("watch/".$item['item_id'], "GET", array());
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
				<a href="profile.php?id=<?= $uid ?>" class="arial blue font24 b"><?= $user["firstname"].' '.$user["lastname"] ?></a>
				<p class="pl10 verdana font18"><?= 'Gender: '.ucfirst($user['gender']) ?></p>
                <p class="black arial font18 mt15"></p>
            <?php } else { ?>
                <span class="pl10 pr10 arial font24"><?= ucfirst($item["category"]) ?></span>
				<a href="show_item.php?id=<?= $item["item_id"] ?>" class="arial blue font24 b"><?= $item["title"] ?></a>
				<p class="pl10 verdana font18"><?= $item["description"] ?></p>
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
            <span class="center mr15 b"><a href="<?= $type == "all" ? "#" : "search_result.php" ?>" class="<?= $type == "all" ? "carmine" : "light-red" ?>">All</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "people" ? "#" : "search_result.php?type=people" ?>" class="<?= $type == "people" ? "carmine" : "light-red" ?>">People</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "offer" ? "#" : "search_result.php?type=offer" ?>" class="<?= $type == "offer" ? "carmine" : "light-red" ?>">Offers</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "need" ? "#" : "search_result.php?type=need" ?>" class="<?= $type == "need" ? "carmine" : "light-red" ?>">Needs</a></span>
            <span class="center">/</span>
            <span class="center ml15 b"><a href="<?= $type == "event" ? "#" : "search_result.php?type=event" ?>" class="<?= $type == "event" ? "carmine" : "light-red" ?>">Events</a></span>
        </p>

		<div>
		<?php
			//$has_more = $items['has_more'];
			//$items = $items['items'];
            //print_r($items);
			//if (count($items) == 0)
				//echo '<p class="center font18">Sorry, no result found.</p>';
			//for ($i = 0; $i < count($items); $i++)
			//	render_item($items[$i]);
            render_item('user', 1);
            render_item('item', 11);
            render_item('item', 9);
            render_item('item', 5);
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