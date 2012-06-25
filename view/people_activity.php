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

			<a href="#" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow">follow</a>
			<div class="intro w500 ml90">
				<span class="pl10 pr10 arial font24"><?= ucfirst($item["category"]) ?></span>
				<a href="show_item.php?id=<?= $item["item_id"] ?>" class="arial blue font24 b"><?= $item["title"] ?></a>
				<p class="pl10 verdana font18"><?= $item["description"] ?></p>
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

    $(function(){
        $(".avatar").mouseover(function(){
/*
            console.log($(this));
            console.log($(this).offset());
            console.log($(document).scrollTop());
            console.log($(document).scrollLeft());
*/
            $("#person_info .info-content").html('<p>loading, please wait…</p>');
            var info_off = $(this).offset();
            $("#person_info").css({"top": info_off.top, "left": info_off.left+$(this).width()}).show();
            if(typeof info_cache[ $(this).attr("uid") ] == "undefined"){
                $.post(
                    "../controller/profile.php",
                    {
                        "type": "get",
                        "uid": $(this).attr("uid")
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
                                str = '<p>' + d["content"]["firstname"] + ' ' + d["content"]["lastname"] + '</p>' + '<p>' + d["content"]["work_location"] + ' ' + d["content"]["work_fields"] + '</p>';
                                break;
                            case 0:
                                str = '<p>The connection is interrupted.</p>';
                                break;
                            
                        }
                        $("#person_info .info-content").html(str);
                    },
                    "json"
                );
            }else{
                var uid = $(this).attr("uid");
                str = '<p>' + info_cache[uid]["firstname"] + ' ' + info_cache[uid]["lastname"] + '</p>' + '<p>' + info_cache[uid]["work_location"] + ' ' + info_cache[uid]["work_fields"] + '</p>';
                $("#person_info .info-content").html(str);
            }
            
        }).mouseout(function(){
            $("#person_info").hide();
        });
        $("#person_info").mouseover(function(){
            $(this).show();
        }).mouseout(function(){
            $(this).hide();
        });
    });
</script>

<?php include("footer.php"); ?>