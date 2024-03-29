<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$type = isset($_GET["type"]) ? $_GET["type"] : "all";
	
	render_header('People & Activity');
	render_nav('people_activity');
	
	$data = array(
		'sort' => 'time',
		'count' => 10,
		'page' => 0);
	$ret = callapi($type == "all" ? "items" : "items/".$type, "GET", $data);
	$items = json_decode($ret['content'], true);
	
	$ret = callapi("items/count", "GET", array());
	$items_count = json_decode($ret['content'], true);
	
	function render_item($item) { ?>
		<div class="mt10 p10 border-t">
			<a href="profile.php?id=<?= $item["publisher_id"] ?>">
				<img class="avatar fl" src="<?= get_avatar_by_id($item["publisher_id"]) ?>" uid="<?php echo $item["publisher_id"];?>" />
			</a>
            
            <?php
                $get_create = callapi("items", "GET", array("count" => 10000, "page" => 0, "author_id" => $_COOKIE["OH_id"]));
                $get_create = json_decode($get_create["content"], true);
                $create_ids = array();
                foreach($get_create["items"] as $c){
                    $create_ids[] = $c["item_id"];
                }
            
                if(!in_array($item["item_id"], $create_ids)){
                    $get_follow = callapi("watch/".$item['item_id'], "GET", array());
                    $action = ($get_follow['code'] == 404) ? 'watch' : 'unwatch';
            ?>
                    <a name="watch_btn" action="<?php echo $action?>" iid="<?php echo $item['item_id']?>" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">
                        <?php 
                            if ($action == 'watch') {
                                echo 'follow';
                            } else {
                                echo 'unfollow';
                            }
                        ?>
                    </a>
            <?php }?>
            
            <div class="intro w500 ml90">
				<span class="pl10 pr10 arial font24"><?= ucfirst($item["category"]) ?></span>
				<a href="show_item.php?id=<?= $item["item_id"] ?>" class="arial blue font24 b"><?= $item["title"] ?></a>
				<p class="pl10 verdana font18"><?= $item["description"] ?></p>
				<a href="show_item.php?id=<?= $item["item_id"] ?>" class="pl10 verdana blue font18"><?= "comment(".$item["comment_count"].")" ?></a>
				<p class="black arial font18 mt15">
					<span class="tag">IT<a>star</a></span>
					<span class="tag">O<a>star</a></span>
					<span class="tag">Medicine<a>star</a></span>
					<span class="tag">Event<a>star</a></span>
				</p>
			</div>
		</div><?php
	}
?>

<link style="text/css" href="../css/people_activity.css" rel="stylesheet"/>
<input type="hidden" id="cookie_self_id" value="<?php echo $_COOKIE["OH_id"];?>" />
<div id="content_wrap" class="wrap bg-white box-shadow">
<div class="p20 overflow">
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
            <span class="center mr15 b"><a href="<?= $type == "all" ? "#" : "people_activity.php" ?>" class="<?= $type == "all" ? "carmine" : "light-red" ?>">All</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "offer" ? "#" : "people_activity.php?type=offer" ?>" class="<?= $type == "offer" ? "carmine" : "light-red" ?>">Offers (<?= $items_count["offer"] ?>)</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "need" ? "#" : "people_activity.php?type=need" ?>" class="<?= $type == "need" ? "carmine" : "light-red" ?>">Needs (<?= $items_count["need"] ?>)</a></span>
            <span class="center">/</span>
            <span class="center ml15 b"><a href="<?= $type == "event" ? "#" : "people_activity.php?type=event" ?>" class="<?= $type == "event" ? "carmine" : "light-red" ?>">Events (<?= $items_count["event"] ?>)</a></span>
        </p>

		<div>
		<?php
			$has_more = $items['has_more'];
			$items = $items['items'];
            //print_r($items);
			if (count($items) == 0)
				echo '<p class="center font18">There is no '.$type.'.</p>';
			for ($i = 0; $i < count($items); $i++)
				render_item($items[$i]);
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
                if (type == 'watch') {
                    that.attr("action", "unwatch");
                    that.html('unfollow');
                }
                else{
                    that.attr("action", "watch");
                    that.html('follow');
                }
            },
            "json"
        );
    }
    
    $(function(){
        $(".avatar").mouseover(function(){
            $("#person_info .info-content").html('<p class="b">loading, please wait…</p>');
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
        
        $("a[name='watch_btn']").each(function(){
            var pp = $(this);
            $(this).bind("click", { t: pp }, watch_btn_click);
        });
        
        $("#follow_btn").live("click", function(){
            var type = $(this).attr("f_type"),
                uid = $(this).attr("uid");
            $("#msgbox").html("Processing…");
            $.getJSON(
                "../controller/follow.php",
                {
                    "type": type,
                    "id": uid
                },
                function(d){
                    if(d.code != 200){
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