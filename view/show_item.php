<?php require_once("../common.php"); ?>
<?php require_once("view_helper.php"); ?>
<?php
    $id = $_GET["id"];
	$ret = callapi("items/".$id, "GET", array());
	$item = json_decode($ret['content'], true);

	if ($ret["code"] == 200)
	{
		$type = $item["category"];
		render_header(ucfirst($type)." ".$item["title"]);
		
		$ret = callapi("profile/".$item["publisher_id"], "GET", array());
		$pub = json_decode($ret["content"], true);
	} else {
		render_header("Error");
	}
	render_nav('people_activity');
?>
<link rel="stylesheet" type="text/css" href="../css/show_item.css" media="all" />

<div id="content_wrap" class="wrap bg-white box-shadow">
<div class="p20 overflow">
<?php if ($ret["code"] != 200) { ?>
	<div class="center font20 red">
		<p>Error: Item ID is invalid.</p>
	</div>
<?php } else { ?>
	<div id="l_side" class="fl w670">
		<h1 class="pink m10 p10 border-b font24"><?= ucfirst($type)." Information" ?></h1>
		<div>
			<span class="key">Title of <?= $type ?>:</span>
			<span class="value"><?= $item["title"] ?></span>
		</div>
		<div>
			<span class="key">Description:</span>
			<span class="value"><?= $item["description"] ?></span>
		</div>
		<div>
			<span class="key">Fields of Work:</span>
			<span class="value"><?= $item["work_fields"] ?></span>
		</div>
		<div>
			<span class="key">Location of Work:</span>
			<span class="value"><?= $item["work_location"] ?></span>
		</div>
		<div>
			<span class="key">Target Population:</span>
			<span class="value"><?= $item["target_population"] ?></span>
		</div>
		<?php if ($type == "event") { ?>
			<div>
				<span class="key">Start Date:</span>
				<span class="value"><?= date("Y-m-d", $item["start_date"]) ?></span>
			</div>
			<div>
				<span class="key">End Date:</span>
				<span class="value"><?= date("Y-m-d", $item["end_date"]) ?></span>
			</div>
		<?php } ?>
	</div>
	<div id="r_side" class="fr w300 font16">
		<h1 class="pink m10 p10 border-b font24">Publisher</h1>
		<div class="m10 p10 overflow">
			<img class="fl avatar" src="../image/blank-avatar.gif" />
			<a href="profile.php?id=<?= $item["publisher_id"] ?>" class="ml20 arial blue font24 b">
				<?= $pub["firstname"]." ".$pub["lastname"] ?></a>
			<div class="overflow">
				<span class="ml20mtb5mr10 fl">Gender: </span>
				<span class="r_value"><?= $pub["gender"] ?></span>
			</div>
		</div>
		<div class="m10 p10 overflow">
			<div><span class="r_key">Email: </span><a href="mailto:<?= $pub["email"] ?>" class="r_value"><?= $pub["email"] ?></a></div>
			<div><span class="r_key">Languages: </span><span class="r_value"><?= $pub["languages"] ?></span></div>
			<div><span class="r_key">Fields of Work: </span><span class="r_value"><?= $pub["work_fields"] ?></span></div>
			<div><span class="r_key">Location of Work: </span><span class="r_value"><?= $pub["work_location"] ?></span></div>
			<div><span class="r_key">Target Population: </span><span class="r_value"><?= $pub["target_population"] ?></span></div>
		</div>
	</div>
<?php } ?>
</div>
</div>

<?php include("footer.php");?>