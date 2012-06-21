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
	$ret = callapi("items", "GET", $data);
	
	function render_item($item) { ?>
		<div class="mt10 p10 border-t">
			<img class="avatar fl" src="" />
			<a href="#" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow">follow</a>
			<div class="intro w500 ml90">
				<span class="pl10 pr10 arial font24"><?= ucfirst($item["category"]) ?></span>
				<span class="arial blue font24 b"><?= $item["title"] ?></span>
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

<div id="content_wrap" class="wrap bg-white"><!--clear-->
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
            <span class="center ml15 mr15 b"><a href="<?= $type == "offer" ? "#" : "people_activity.php?type=offer" ?>" class="<?= $type == "offer" ? "carmine" : "light-red" ?>">Offers</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "need" ? "#" : "people_activity.php?type=need" ?>" class="<?= $type == "need" ? "carmine" : "light-red" ?>">Needs</a></span>
            <span class="center">/</span>
            <span class="center ml15 b"><a href="<?= $type == "event" ? "#" : "people_activity.php?type=event" ?>" class="<?= $type == "event" ? "carmine" : "light-red" ?>">Events</a></span>
        </p>

		<div>
		<?php
			$content = json_decode($ret['content'], true);
			$has_more = $content['has_more'];
			$items = $content['items'];
			for ($i = 0; $i < count($items); $i++)
				render_item($items[$i]);
		?>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

	});
</script>

<?php include("footer.php"); ?>