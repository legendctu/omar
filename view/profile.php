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
            <span class="center mr15 b"><a href="<?= $type == "activity" ? "#" : "profile.php" ?>" class="<?= $type == "activity" ? "carmine" : "light-red" ?>">Activity</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "information" ? "#" : "profile.php?type=information" ?>" class="<?= $type == "information" ? "carmine" : "light-red" ?>">Information</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "innovation" ? "#" : "profile.php?type=innovation" ?>" class="<?= $type == "innovation" ? "carmine" : "light-red" ?>">Innovation</a></span>
        </p>
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
			<div id="basic-form" class="pl20 pr20 form font18">
				<span>Firstname:</span> <p><?php echo $basic_info["firstname"];?></p><br />
				<span>Lastname:</span> <p><?php echo $basic_info["lastname"];?></p><br />
                <span id="gender_select">Gender:</span> <p><?php echo $basic_info["gender"];?></p><br />
				<span>Languages:</span> <p><?php echo $basic_info["languages"];?></p><br />
				<span>Work Fields:</span> <p><?php echo $basic_info["work_fields"];?></p><br />
				<span>Work Location:</span> <p><?php echo $basic_info["work_location"];?></p><br />
                <span>Target Population:</span> <p><?php echo $basic_info["target_population"];?></p><br />
			</div>
		</div>
		<div id="contact">
			<div id="contact-header" class="overflow m10 p10 border-b">
				<h3 class="fl font20 pink b ml20">Contact Information</h3>
				<a id="contact-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
				<a id="contact-download" class="fr button-bg white r14 arial font18 b shadow">Download</a>
			</div>
			<div id="contect-form" class="pl20 pr20 form font18">
				<span>Mobile number country code:</span> <p><?php echo $contact_info["phone_number_country_code"];?></p><br />
				<span>My mobile number:</span> <p><?php echo $contact_info["phone_number"];?></p><br />
				<span>Street:</span> <p><?php echo $contact_info["street"];?></p><br />
				<span>City:</span> <p><?php echo $contact_info["city"];?></p><br />
				<span>State or Province:</span> <p><?php echo $contact_info["province"];?></p><br />
				<span>Zip/Postal Code:</span> <p><?php echo $contact_info["zip_code"];?></p><br />
				<span>Country:</span> <p><?php echo $contact_info["country"];?></p><br />
			</div>
		</div>
        
		<div id="organization">
			<div id="organization-header" class="overflow m10 p10 border-b">
				<h3 class="fl font20 pink b ml20">Organization Information</h3>
				<a id="organization-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
				<a id="organization-download" class="fr button-bg white r14 arial font18 b shadow">Download</a>
			</div>
			<div id="organization-form" class="pl20 pr20 form font18">
				<span>Organization name:</span> <p><?php echo $org_info["name"];?></p><br />
				<span>Organization acronym:</span> <p><?php echo $org_info["acronym"];?></p><br />
				<span>Date organization formed:</span> <p><?php echo $org_info["formed_date"];?></p><br />
				<span>Organization website URL:</span> <p><?php echo $org_info["website"];?></p><br />
				<span>Organization type:</span> <p><?php echo $org_info["type"];?></p><br />
				<span>Number of employees:</span> <p><?php echo $org_info["employee_number"];?></p><br />
				<span>Organization’s estimated annual budget (US Dollars):</span> <p><?php echo $org_info["annual_budget"];?></p><br />
				<span>Organization phone number country code:</span> <p><?php echo $org_info["phone_number_country_code"];?></p><br />
				<span>Organization phone number:</span> <p><?php echo $org_info["phone_number"];?></p><br />
			</div>
		</div>
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
						<a href="profile.php?id=<?= $follower[$i]["id"] ?>" class="fl ml10 mr10 font16 blue">
							<?= get_fullname($user) ?></a>
						<?php if (!is_me($follower[$i]["id"])) {
						    $tmp_is_followed = is_followed($follower[$i]["id"]);?>
							<a name="follow" uid="<?= $follower[$i]["id"] ?>" type="<?php echo $tmp_is_followed ? "unfollow" : "follow";?>" class="fr ml20 button-bg white r14 arial font14 b shadow"><?php echo $tmp_is_followed ? "unfollow" : "follow";?></a>
						<?php } ?>
						<img class="star fr" src="../image/<?= $follower[$i]["inverted"] ? "star.png" : "star-empty.png" ?>" />
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
						<a href="profile.php?id=<?= $following[$i]["id"] ?>" class="fl ml10 mr10 font16 blue">
							<?= get_fullname($user) ?></a>
						<?php if (!is_me($following[$i]["id"])) { 
						    $tmp_is_followed = is_followed($following[$i]["id"]);?>
							<a name="follow" uid="<?= $following[$i]["id"] ?>" type="<?php echo $tmp_is_followed ? "unfollow" : "follow";?>" class="fr ml20 button-bg white r14 arial font14 b shadow"><?php echo $tmp_is_followed ? "unfollow" : "follow";?></a>
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
        in_edit = 0;
        $(document).ready(function(){
            $(".edit").click(function(){
                if (in_edit == 0) {
                    in_edit = 1;
                    $(this).html('Save');
                    $(this).next().html('Cancel');
                    $(this).parent().next('div').children('span')
                            .each(function(){
                                $(this).next().addClass('hidden');
                                if ($(this).attr('id') != 'gender_select') {
                                    v = $(this).next().html();
                                    $(this).after("<input type='text' value='" + v + "'>");
                                }
                                else {
                                    v = $(this).next().html();
                                    $(this).after("<select><option>male</option><option>female</option><option>unknown</option></select>");
                                    $(this).next("select").val(v);
                                }
                    });
                }
                else {
                    in_edit = 0;
                    $(this).html('Edit');
                    $(this).next().html('Download');
                    data = new Array();
                    $(this).parent().next('div').children('input, select')
                        .each(function(){
                            data.push($(this).val());
                            $(this).next().removeClass('hidden');
                            $(this).remove();
                        });
                    post_info($(this).children('a:first-child').attr("id"), data);
                }
            });
            
            $(".cancel").click(function(){
                if (in_edit == 1) {
                    in_edit = 0;
                    $(this).prev('a').html('Edit');
                    $(this).html('Download');
                    $(this).parent().next('div').children('input, select')
                            .each(function(){
                                $(this).next().removeClass('hidden');
                                $(this).remove();
                    });
                }
            });
        });
        
        function post_info(type, data)
        {
            if (type = 'basic-form') 
            {
                $.post(
                    "../controller/profile.php",
                    {
                        "type": "basic",
                        "firstname": data[0],
                        "lastname": data[1],
                        "gender": data[2],
                        "languages": data[3],
                        "work_fields": data[4],
                        "work_location": data[5],
                        "target_population": data[6],
                        
                    },
                    function(d){
                        i = 0;
                        $("#"+type).children("p").each(function(){
                            $(this).html(data[i++]);
                        });
                    },
                    "json"
                );
            }
        }
    </script>

	<script type="text/javascript">
		$("a[name='follow']").click(function() {
            var uid = $(this).attr("uid"),
                type = $(this).attr("type"),
                that = $(this);
            $.getJSON(
                "../controller/follow.php",
                {
                    "id" : uid,
                    "type" : type
                },
                function(d) {
                    console.log(d);
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
                                    that.attr("type", "unfollow").html("unfollow");
                                });
                            }else{
                                $("a[name='follow'][uid='" + uid + "']").each(function(){
                                    that.attr("type", "follow").html("follow");
                                });
                            }
                            break;
                    }
                }
            );
		});
	</script>
	
<?php include("footer.php"); ?>