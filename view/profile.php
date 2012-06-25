<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$type = isset($_GET["type"]) ? $_GET["type"] : "activity";

	render_header('Profile');
	render_nav('profile');

	$ret = callapi("profile", "GET", array());
    $basic_info = json_decode($ret["content"], true);
    
    //$contact_info
    //$org_info
?>

<link style="text/css" href="../css/profile.css" rel="stylesheet"/>

<div id="content_wrap" class="wrap bg-white box-shadow">
<div class="p20 overflow">
	<div id="l_side" class="fl w670">
		<div id="status" class="overflow m10 p10 border-b">
			<img class="avatar fl" src="../image/blank-avatar.gif" />
			<div class="fl ml20">
				<textarea type="text" id="status" rows="3" class="w500"></textarea><br />
				<a id="update" class="fr mt10 button-bg white r14 arial font18 b shadow">Submit</a>
			</div>
		</div>
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
				<a id="basic-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
				<a id="basic-download" class="fr button-bg white r14 arial font18 b shadow">Download</a>
			</div>
			<div id="basic-form" class="pl20 pr20 form font18">
				<span>Firstname:</span> <p><?php echo $basic_info["firstname"];?></p><br />
				<span>Lastname:</span> <p><?php echo $basic_info["lastname"];?></p><br />
                <span>Gender:</span> <p><?php echo $basic_info["gender"];?></p><br />
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
			<div class="font24 white bg-blue pl10">Followers(10)</div>
			<ul class="list p10">
				<li><div class="overflow">
					<img class="small-avatar fl" src="../image/blank-avatar.gif" />
					<p class="fl pl10 pr10 font20">username</p>
					<a id="follow" class="fr ml20 button-bg white r14 arial font18 b shadow">follow</a>
					<img class="star fr" src="../image/blank-avatar.gif" />
				</div></li>
				<li><div class="overflow">
					<img class="small-avatar fl" src="../image/blank-avatar.gif" />
					<p class="fl pl10 pr10 font20">username</p>
					<a id="follow" class="fr ml20 button-bg white r14 arial font18 b shadow">follow</a>
					<img class="star fr" src="../image/blank-avatar.gif" />
				</div></li>
			</ul>
			<a href="#" class="font18 arial carmine b">Show All</a>
		</div>
		<div class="center border-blue mt20">
			<div class="font24 white bg-blue pl10">Following(10)</div>
			<ul class="list p10">
				<li><div class="overflow">
					<img class="small-avatar fl" src="../image/blank-avatar.gif" />
					<p class="fl pl10 pr10 font20">username</p>
					<a id="follow" class="fr ml20 button-bg white r14 arial font18 b shadow">follow</a>
					<img class="star fr" src="../image/blank-avatar.gif" />
				</div></li>
			</ul>
			<a href="#" class="font18 arial carmine b">Show All</a>
		</div>
		<div class="center border-blue mt20">
			<div class="font24 white bg-blue pl10">Tag I Follow(10)</div>
			
			<a href="#" class="font18 arial carmine b">Show All</a>
		</div>
	</div>
</div>
</div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".edit").toggle(function(){
                $(this).html('Save');
                $(this).next('a').html('Cancel').addClass('cancel');
                $(this).parent().next('div').children('span')
                        .each(function(){
                            $(this).next().addClass('hidden');
                            v = $(this).next().html();
                            $(this).after("<input type='text' value='" + v + "'>");
                        });
            }, function(){
                $(this).html('Edit');
                $(this).next('a').html('Download').removeClass('cancel');
                data = new Array();
                $(this).parent().next('div').children('input')
                        .each(function(){
                            data.push($(this).val());
                            $(this).next().removeClass('hidden');
                            $(this).remove();
                        });
                post_info($(this).children('a:first-child').attr("id"), data);
            });
            
            $('.cancel').live('click', function(){
                $(this).prev('a').html('Edit');
                $(this).html('Download').removeClass('cancel');
                $(this).parent().next('div').children('input')
                        .each(function(){
                            $(this).next().removeClass('hidden');
                            $(this).remove();
                        });
            });
        });
        function post_info(type, data)
        {
            if (type = 'basic-form') 
            {
                $.post(
                    "../controller/profile.php",
                    {
                        "firstname": data[0],
                        "lastname": data[1],
                        "gender": data[2],
                        "languages": data[3],
                        "work_fields": data[4],
                        "work_location": data[5],
                        "target_population": data[6]
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

<?php include("footer.php"); ?>