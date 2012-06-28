<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$type = isset($_GET["type"]) ? $_GET["type"] : "activity";
	$id = isset($_GET["id"]) ? $_GET["id"] : $_COOKIE['OH_id'];

	render_header('Profile');
	render_nav('profile');

	$ret = callapi("profile/".$id, "GET");
	$basic_info = json_decode($ret["content"], true);
    $ret = callapi("profile/contact_information", "GET");
    $contact_info = json_decode($ret["content"], true);
    $ret = callapi("profile/organization_information", "GET");
    $org_info = json_decode($ret["content"], true);
?>

<link style="text/css" href="../css/profile.css" rel="stylesheet"/>

<div id="content_wrap" class="wrap bg-white box-shadow">
<div class="p20 overflow">
	<div id="l_side" class="fl w670">
		<?php if (is_me($id)) { ?>
			<div id="status" class="overflow m10 p10 border-b">
				<img class="avatar fl" src="<?= get_avatar($basic_info["email"]) ?>" />
				<div class="fl ml20">
					<textarea type="text" id="status" rows="3" class="w500"></textarea><br />
					<a id="update" class="fr mt10 button-bg white r14 arial font18 b shadow">Submit</a>
				</div>
			</div>
		<?php } ?>
		<p id="l_side_navi" class="pl20 font24 freshcolor">
            <span class="center mr15 b"><a <?= $type == "activity" ? "" : 'href="profile.php?type=activity&id=' . $id . '"' ?> class="<?= $type == "activity" ? "carmine" : "light-red" ?>">Activity</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a <?= $type == "information" ? "" : 'href="profile.php?type=information&id=' . $id . '"' ?> class="<?= $type == "information" ? "carmine" : "light-red" ?>">Information</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a <?= $type == "innovation" ? '' : 'href="profile.php?type=innovation&id=' . $id . '"' ?> class="<?= $type == "innovation" ? "carmine" : "light-red" ?>">Innovation</a></span>
        </p>
        
<!-- Activity / Information / Innovation block start -->
<?php
switch($type){
    case "activity": ?>
        <input type="hidden" id="user_id" value="<?=$id;?>" />
        <div id="activities_block">
            <div class="mt10 p10 border-t">
    			<a href="profile.php?id=8">
    				<img class="avatar fl" src="http://www.gravatar.com/avatar/2e56650d65285819a2f19bef317a9def" uid="8">
    			</a>
                <a name="watch_btn" action="watch" iid="4" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">
                    follow            </a>
                <div class="intro w500 ml90">
    				<span class="pl10 pr10 arial font24">User Activated</span>
    				<a href="show_item.php?id=4" class="arial blue font24 b">Yach Liu</a>
    				<p class="pl10 verdana font18">Yach Liu activated the account.</p>
    			</div>
    			<div class="clear"></div>
    		</div>
    		
    		<div class="mt10 p10 border-t">
    			<a href="profile.php?id=8">
    				<img class="avatar fl" src="http://www.gravatar.com/avatar/2e56650d65285819a2f19bef317a9def" uid="8">
    			</a>
                <a name="watch_btn" action="watch" iid="4" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">
                    follow            </a>
                <div class="intro w500 ml90">
    				<span class="pl10 pr10 arial font24">Need</span>
    				<a href="show_item.php?id=4" class="arial blue font24 b">植树节</a>
    				<p class="pl10 verdana font18">需要10个人到香山做引导员。</p>
    				<p class="black arial font18 mt15">
    					<span class="tag">IT<a>star</a></span>
    					<span class="tag">O<a>star</a></span>
    					<span class="tag">Medicine<a>star</a></span>
    					<span class="tag">Event<a>star</a></span>
    				</p>
    			</div>
    			<div class="clear"></div>
    		</div>
		</div>
		<div class="center font18 b carmine mt20"><a id="show_more_activities">Show More Activities</a><span id="loading_activities" class="light-red none">Loading, please wait…</span></div>
		<script src="../script/profile_activity.js"></script>
<?php   break;//Activity block end
    case "information": ?>
        <div id="basic">
			<div id="basic-header" class="overflow m10 p10 border-b">
				<h3 class="fl font20 pink b ml20">Basic Information</h3>
				<?php if (is_me($id)) { ?>
					<a id="basic-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
					<a id="basic-download" class="fr button-bg white r14 arial font18 b shadow cancel">Download</a>
				<?php } else { 
				    $tmp_is_followed = is_followed($id);?>
					<a name="follow" uid="<?= $id ?>" type="<?php echo $tmp_is_followed ? "unfollow" : "follow";?>" class="fr button-bg white r14 arial font18 b shadow"><?php echo $tmp_is_followed ? "unfollow" : "follow";?></a>
				<?php } ?>
			</div>
			<div id="basic-form" class="pl20 pr20 form font18" in_edit="0">
				<span>Firstname:</span> <p><?php echo $basic_info["firstname"];?></p><br />
				<span>Lastname:</span> <p><?php echo $basic_info["lastname"];?></p><br />
                <span id="gender_select" is_special="select">Gender:</span> <p><?php echo $basic_info["gender"];?></p><br />
				<span>Languages:</span> <p><?php echo $basic_info["languages"];?></p><br />
				<span>Work Fields:</span> <p><?php echo $basic_info["work_fields"];?></p><br />
				<span>Work Location:</span> <p><?php echo $basic_info["work_location"];?></p><br />
                <span>Target Population:</span> <p><?php echo $basic_info["target_population"];?></p><br />
			</div>
		</div>
		<div id="contact" class="clear">
			<div id="contact-header" class="overflow m10 p10 border-b">
				<h3 class="fl font20 pink b ml20">Contact Information</h3>
                <?php if (is_me($id)) { ?>
                    <a id="contact-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
                    <a id="contact-download" class="fr button-bg white r14 arial font18 b shadow cancel">Download</a>
                <?php }?>
			</div>
			<div id="contect-form" class="pl20 pr20 form font18" in_edit="0">
				<span>Mobile number country code:</span> <p><?php echo $contact_info["phone_number_country_code"];?></p><br />
				<span>My mobile number:</span> <p><?php echo $contact_info["phone_number"];?></p><br />
				<span>Street:</span> <p><?php echo $contact_info["street"];?></p><br />
				<span>City:</span> <p><?php echo $contact_info["city"];?></p><br />
				<span>State or Province:</span> <p><?php echo $contact_info["province"];?></p><br />
				<span>Zip/Postal Code:</span> <p><?php echo $contact_info["zip_code"];?></p><br />
				<span>Country:</span> <p><?php echo $contact_info["country"];?></p><br />
			</div>
		</div>
        
		<div id="organization" class="clear">
			<div id="organization-header" class="overflow m10 p10 border-b">
				<h3 class="fl font20 pink b ml20">Organization Information</h3>
                <?php if (is_me($id)) { ?>
                    <a id="organization-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
                    <a id="organization-download" class="fr button-bg white r14 arial font18 b shadow cancel">Download</a>
                <?php }?>
			</div>
			<div id="organization-form" class="pl20 pr20 form font18" in_edit="0">
				<span>Organization name:</span> <p><?php echo $org_info["name"];?></p><br />
				<span>Organization acronym:</span> <p><?php echo $org_info["acronym"];?></p><br />
				<span id="form_date" is_special="date">Date organization formed:</span> <p><?php echo empty($org_info["formed_date"]) ? "" : date("Y-m-d", $org_info["formed_date"]);?></p><br />
				<span>Organization website URL:</span> <p><?php echo $org_info["website"];?></p><br />
				<span>Organization type:</span> <p><?php echo $org_info["type"];?></p><br />
				<span id="emp_select" is_special="select">Number of employees:</span> <p><?php echo $org_info["employee_number"];?></p><br />
				<span id="bgt_select" is_special="select">Organization’s estimated annual budget (US Dollars):</span> <p><?php echo $org_info["annual_budget"];?></p><br />
				<span>Organization phone number country code:</span> <p><?php echo $org_info["phone_number_country_code"];?></p><br />
				<span>Organization phone number:</span> <p><?php echo $org_info["phone_number"];?></p><br />
			</div>
		</div>
		
        <script type="text/javascript" src="../script/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="../script/jquery.ui.core.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/base/jquery.ui.all.css" media="all" />
        <script type="text/javascript" src="../script/profile_information.js"></script>
        
<?php   break;//Information block end
    case "innovation":
        break;//Innovation block end
}?>
    
<!-- Activity / Information / Innovation block end -->
	</div>
	<div id="r_side" class="fr w300">
		<div class="center border-blue">
		<?php
			$ret = callapi("user/".$id."/follower", "GET", array());
			$r_content = json_decode($ret["content"], true);
			$follower = $r_content["users"];
		?>
			<div class="font24 white bg-blue pl10">Followers(<?= count($follower) ?>)</div>
			<?php if (count($follower) > 0) { ?>
				<ul class="list pb10 pl10 pr10">
				<?php for ($i = 0; $i < count($follower); $i++) {
				    $res = callapi("profile/".$follower[$i]["id"], "GET", array());
					$user = json_decode($res["content"], true); ?>
					<li class="mt10"><div class="overflow">
						<a href="profile.php?id=<?= $follower[$i]["id"] ?>" >
							<img class="small-avatar fl" src="<?= get_avatar($user["email"]) ?>" /></a>
						<a href="profile.php?id=<?= $follower[$i]["id"] ?>" class="fl ml10 mt8 font16 blue long-name">
							<?= get_fullname($user) ?></a>
						<?php if (!is_me($follower[$i]["id"])) {
						    $tmp_is_followed = is_followed($follower[$i]["id"]);?>
							<a name="follow" uid="<?= $follower[$i]["id"] ?>" type="<?php echo $tmp_is_followed ? "unfollow" : "follow";?>" class="fr ml5 mt6 button-bg white r14 arial font14 b shadow"><?php echo $tmp_is_followed ? "unfollow" : "follow";?></a>
						<?php } ?>
						<img class="star fr mt9" src="../image/<?= $follower[$i]["inverted"] ? "star.png" : "star-empty.png" ?>" />
					</div></li>
				<?php } ?>
				</ul>
				<a href="#" class="font18 arial carmine b">Show All</a>
			<?php } ?>
		</div>
		<div class="center border-blue mt20">
		<?php
			$ret = callapi("user/".$id."/following", "GET", array());
			$r_content = json_decode($ret["content"], true);
			$following = $r_content["users"];
		?>
			<div class="font24 white bg-blue pl10">Following(<?= count($following) ?>)</div>
			<?php if (count($following) > 0) { ?>
				<ul class="list pl10 pr10 pb10">
				<?php for ($i = 0; $i < count($following); $i++) {
				    $res = callapi("profile/".$following[$i]["id"], "GET", array());
					$user = json_decode($res["content"], true); ?>
					<li class="mt10"><div class="overflow">
						<a href="profile.php?id=<?= $following[$i]["id"] ?>" >
							<img class="small-avatar fl" src="<?= get_avatar($user["email"]) ?>" /></a>
						<a href="profile.php?id=<?= $following[$i]["id"] ?>" class="fl mt8 ml10 font16 blue long-name">
							<?= get_fullname($user) ?></a>
						<?php if (!is_me($following[$i]["id"])) { 
						    $tmp_is_followed = is_followed($following[$i]["id"]);?>
							<a name="follow" uid="<?= $following[$i]["id"] ?>" type="<?php echo $tmp_is_followed ? "unfollow" : "follow";?>" class="fr ml5 mt6 button-bg white r14 arial font14 b shadow"><?php echo $tmp_is_followed ? "unfollow" : "follow";?></a>
						<?php } ?>
					</div></li>
				<?php } ?>
				</ul>
				<a href="#" class="font18 arial carmine b">Show All</a>
			<?php } ?>
		</div>
		<div class="center border-blue mt20">
			<div class="font24 white bg-blue pl10">Tag I Follow(10)</div>
			
			<a href="#" class="font18 arial carmine b">Show All</a>
		</div>
	</div>
</div>
</div>

	<script type="text/javascript">
		$("a[name='follow']").click(function() {
            var uid = $(this).attr("uid"),
                type = $(this).attr("type");
            $.ajax({
                url: "../controller/follow.php",
                timeout: 30000,
                type: "GET",
                data: {
                    "id" : uid,
                    "type" : type
                },
                success: function(d) {
                    switch(d.code){
                        case 0:
                            alert("The connection is interrupted. Please try again.");
                            break;
                        case 403:
                            alert("Sorry, you can't follow an admin.");
                            break;
                        case 404:
                            alert("The user you follow doesn't exist.");
                            break;
                        case 200:
                            if(type == "follow"){
                                $("a[name='follow'][uid='" + uid + "']").each(function(){
                                    $(this).attr("type", "unfollow").html("unfollow");
                                    $(this).next("img").attr("src", "../image/star.png");
                                });
                            }else{
                                $("a[name='follow'][uid='" + uid + "']").each(function(){
                                    $(this).attr("type", "follow").html("follow");
                                    $(this).next("img").attr("src", "../image/star-empty.png");
                                });
                            }
                            break;
                    }
                },
                error: function(d){
                    console.log(d);
                    alert("Quest failed. Please try again.");
                },
                dataType: "json"
            });
		});
	</script>
	
<?php include("footer.php"); ?>