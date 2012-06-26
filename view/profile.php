<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$type = isset($_GET["type"]) ? $_GET["type"] : "activity";
	$id = isset($_GET["id"]) ? $_GET["id"] : $_COOKIE['OH_id'];

	render_header('Profile');
	render_nav('profile');

	$ret = callapi("profile/".$id, "GET", array());
	$basic_info = json_decode($ret["content"], true);
    
    //$contact_info
    //$org_info
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
				<?php } else { ?>
					<a name="follow" uid="<?= $id ?>" class="fr button-bg white r14 arial font18 b shadow">Follow</a>
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
				<span>Mobile number country code:</span> <p>123</p><br />
				<span>My mobile number:</span> <p>123</p><br />
				<span>Mailing address type:</span> <p>123</p><br />
				<span>Street:</span> <p>123</p><br />
				<span>City:</span> <p>123</p><br />
			</div>
		</div>
        
		<div id="organization">
			<div id="organization-header" class="overflow m10 p10 border-b">
				<h3 class="fl font20 pink b ml20">Organization Information</h3>
				<a id="organization-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
				<a id="organization-download" class="fr button-bg white r14 arial font18 b shadow">Download</a>
			</div>
			<div id="organization-form" class="pl20 pr20 form font18">
				<span>Mobile number country code:</span> <p>123</p><br />
				<span>My mobile number:</span> <p>123</p><br />
				<span>Mailing address type:</span> <p>123</p><br />
				<span>Street:</span> <p>123</p><br />
				<span>City:</span> <p>123</p><br />
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
				<ul class="list p10">
				<?php for ($i = 0; $i < count($follower); $i++) {
				    $res = callapi("profile/".$follower[$i], "GET", array());
					$user = json_decode($res["content"], true); ?>
					<li><div class="overflow">
						<a href="profile.php?<?= $follower[$i] ?>" >
							<img class="small-avatar fl" src="<?= get_avatar($user["email"]) ?>" /></a>
						<a href="profile.php?id=<?= $follower[$i] ?>" class="fl pl10 pr10 font16 blue">
							<?= get_fullname($user) ?></a>
						<?php if (!is_me($follower[$i])) { ?>
							<a name="follow" uid="<?= $follower[$i] ?>" class="fr ml20 button-bg white r14 arial font14 b shadow">follow</a>
						<?php } ?>
						<img class="star fr" src="../image/<?= "star.png" ?>" />
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
				<ul class="list p10">
				<?php for ($i = 0; $i < count($following); $i++) {
				    $res = callapi("profile/".$following[$i], "GET", array());
					$user = json_decode($res["content"], true); ?>
					<li><div class="overflow">
						<a href="profile.php?<?= $following[$i] ?>" >
							<img class="small-avatar fl" src="<?= get_avatar($user["email"]) ?>" /></a>
						<a href="profile.php?id=<?= $following[$i] ?>" class="fl pl10 pr10 font16 blue">
							<?= get_fullname($user) ?></a>
						<?php if (!is_me($following[$i])) { ?>
							<a name="follow" uid="<?= $following[$i] ?>" class="fr ml20 button-bg white r14 arial font14 b shadow">follow</a>
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
			$.getJSON("../controller/follow.php", { "id" : $(this).attr("uid") }, function(d) {
				console.log(d);
			});
		});
	</script>
	
<?php include("footer.php"); ?>