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

	function render_comment($comment, $publisher_id) {
		$ret = callapi("profile/".$comment["author_id"], "GET");
		$commenter = json_decode($ret["content"], true); ?>
		<div class="m10 p10 border-t overflow">
			<a href="profile.php?id=<?= $comment["author_id"] ?>">
				<img class="small_avatar fl" src="<?= get_avatar($commenter["email"]) ?>" />
			</a>
			<p class="fl ml20 w430 font20">
				<span class="fl blue mr20"><?= get_fullname($commenter) ?></span>
				<?= $comment["text"] ?>
			</p>
			<?php if (is_me($publisher_id)) { ?>
				<a name="comment-delete" cid="<?= $comment["comment_id"] ?>" class="fr ml20 button-bg white r14 arial font18 b shadow">Delete</a>
				<span id="del-msgbox" class="ml30"></span>
			<?php } ?>
		</div><?php
	}
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
		<div class="m10 p10 border-b overflow">
			<h1 class="fl pink font24"><?= ucfirst($type)." Information" ?></h1>
			<?php if (is_me($item["publisher_id"])) { ?>
				<a id="info-edit" class="fr ml20 button-bg white r14 arial font18 b shadow edit">Edit</a>
			<?php } ?>
		</div>
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
		<div class="m10 p10 overflow">
			<h1 class="pink font20"><?= "Comments" ?></h1>
			<?php
				$ret = callapi("items/".$id."/comments", "GET");
				$comments = json_decode($ret["content"], true);
				$comment = $comments["comments"];
				for ($i = 0; $i < count($comment); $i++) {
					render_comment($comment[$i], $item["publisher_id"]);
				} ?>
			<div class="m10 p10 box-shadow overflow r7">
				<label class="arial b m10 blue">Add comment</label><br />
				<textarea name="text" id="text" class="m10 w550 h100"></textarea>
				<input type="hidden" name="post_id" id="post_id" value="<?= $id ?>" /><br />
				<a id="post-comment" class="button-bg white r14 arial font24 b shadow m10">Post</a>
				<span id="msgbox" class="ml30"></span>
			</div>
		</div>
	</div>
	<div id="r_side" class="fr w300 font16">
		<h1 class="pink m10 p10 border-b font24">Publisher</h1>
		<div class="m10 p10 overflow">
			<img class="fl avatar" src="<?= get_avatar($pub["email"]) ?>" />
			<a href="profile.php?id=<?= $item["publisher_id"] ?>" class="ml20 arial blue font24 b">
				<?= $pub["firstname"]." ".$pub["lastname"] ?></a>
			<div class="overflow">
				<span class="ml20mtb5mr10 fl">Gender: </span>
				<span class="r_value"><?= $pub["gender"] ?></span>
			</div>
		</div>
		<div class="m10 p10 overflow">
			<div class="clear"><span class="r_key">Email: </span><a href="mailto:<?= $pub["email"] ?>" class="r_value"><?= $pub["email"] ?></a></div>
			<div class="clear"><span class="r_key">Languages: </span><span class="r_value"><?= $pub["languages"] ?></span></div>
			<div class="clear"><span class="r_key">Fields of Work: </span><span class="r_value"><?= $pub["work_fields"] ?></span></div>
			<div class="clear"><span class="r_key">Location of Work: </span><span class="r_value"><?= $pub["work_location"] ?></span></div>
			<div class="clear"><span class="r_key">Target Population: </span><span class="r_value"><?= $pub["target_population"] ?></span></div>
		</div>
	</div>
<?php } ?>
</div>
</div>

<script type="text/javascript">
	$('#post-comment').click(function() {
		var data = {
			"text"    : $('#text').val(),
			"post_id" : $('#post_id').val()
		};
		$.post(
            "../controller/comment.php",
            data,
            function(d) {
                switch(d.code) {
                    case 0:
                        $("#msgbox").addClass("red").html("* The connection is interrupted. Please try again");
                        break;
                    case 401:
                        $("#msgbox").addClass("red").html("* Permission denied");
                        break;
                    case 200:
                        $("#msgbox").html("Comment posted successfully!");
                        window.location.navigate('show_item.php?id=' + $('#post_id').val());
                        break;
                }
            }
        );
	});
	
	$('a[name="comment-delete"]').each(function() {
		$(this).click(function() {
			$.post(
				"../controller/comment.php",
				{
					"delete"  : true,
					"id"      : $(this).attr('cid'),
					"post_id" : $('#post_id').val()
				},
				function(d) {
				    switch(d.code) {
	                    case 0:
	                        $("#del-msgbox").addClass("red").html("* The connection is interrupted. Please try again");
	                        break;
	                    case 401:
	                        $("#del-msgbox").addClass("red").html("* Permission denied");
	                        break;
	                    case 200:
	                        $("#del-msgbox").html("Comment posted successfully!");
	                        window.location.navigate('show_item.php?id=' + $('#post_id').val());
	                        break;
	                }
				}
			);
		});
	});
</script>

<?php include("footer.php");?>
