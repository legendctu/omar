<?php
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