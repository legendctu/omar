<?php

function render_header($title, $is_user = true) {
?>
<html>
    <head>
		<title><?= $title ?> - OmarHub</title>
		<meta http-equiv="Content-Type"content="text/html; charset=utf-8" />
		<link style="text/css" href="../css/base.css" rel="stylesheet"/>
		<script type="text/javascript" src="../script/jquery-1.7.2.min.js"></script>
    </head>
    <body>
		<?php if($is_user && !isset($_COOKIE["OH_user"])) echo "<script type='text/javascript'>window.location='login.php';</script>";?>
		<div class="bg-white">
		<div class="wrap">
			
			<div id="welcome" class="fr font18 pr10 arial light-red">
				<?php if ($is_user) { ?>
				Welcome <a href="#" class="blue b">#username</a>, 
				<a href="login.php" class="arial carmine b">logout</a>
				<?php } else { ?>
				Welcome to <span class="arial carmine b">Omar</span>!
				<?php } ?>
			</div>
			<div class="p20">
				<img src="../image/omarhub-logo.png" width="96" class="mb-15"/>
				<span id="omar" class="georgia"><b>Omar</b></span>
				<span id="hub" class="georgia"><b>Hub</b></span>
			</div>
		</div>
		</div><?php
}

function render_nav($current) {
	$nav = array(
		'profile'         => array('main-navi', 'profile.php',         'gray', 'PROFILE'          ),
		'people_activity' => array('main-navi', 'people_activity.php', 'gray', 'PEOPLE & ACTIVITY'),
		'tags'            => array('main-navi', 'tags.php',            'gray', 'TAGS'             ),
		'create'          => array('main-navi', 'create.php',          'gray', 'CREATE'           ));
	$nav[$current] = array('main-navi-active', '#', 'white', $nav[$current][3]);
	
	function generate_nav_item($nav, $name) {
		?><li class="fl center pl20 pr20 <?= $nav[$name][0] ?>"><a href="<?= $nav[$name][1] ?>" class="<?= $nav[$name][2] ?>"><?= $nav[$name][3] ?></a></li><?php
	}
?>
<div id="navi_wrap" class="navi-bg">
	<div id="navi" class="wrap shadow">
		<ul class="w700 fl b font24">
			<?php generate_nav_item($nav, 'profile'); ?>
			<?php generate_nav_item($nav, 'people_activity'); ?>
			<?php generate_nav_item($nav, 'tags'); ?>
			<?php generate_nav_item($nav, 'create'); ?>
			<li class="clear"></li>
		</ul>
		<div id="search" class="fr pr20">
			<input type="text">
			<img src="../image/Find.png" width="35px" class="find">
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
}
?>