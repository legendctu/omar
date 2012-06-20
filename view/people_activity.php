<?php require_once("view_helper.php"); ?>
<?php
	render_header('People & Activity');
	render_nav('people_activity');
?>

<link style="text/css" href="../css/page.css" rel="stylesheet"/>

<div id="content_wrap" class="wrap bg-white"><!--clear-->
<div class="p20 overflow">
	<div id="l_side" class="fl w250">
		<span class="font24 pink b ml20">Filter</span>
		<hr />
		<div class="ml15 mr15">
			<div class="pl20 white font18 button-bg r14 shadow">
			Field of work
			<span class="pr20 fr">plus</span>
			</div>
			<ul class="black arial font18 mt15">
				<li class="fl tag">IT<a>X</a></li>
				<li class="fl tag">O<a>X</a></li>
				<li class="clear"></li>
			</ul>
		</div>
		<hr class="mt15" />
		<div class="ml15 mr15">
			<div class="pl20 white font18 button-bg r14 shadow">
			Field of work
			<span class="pr20 fr">plus</span>
			</div>
			<ul class="black arial font18 mt15">
				<li class="fl tag">IT<a>X</a></li>
				<li class="fl tag">O<a>X</a></li>
				<li class="clear"></li>
			</ul>
		</div>
	</div>
	<div id="r_side" class="fr">
		<ul id="r_side_navi" class="b font24 freshcolor">
			<li class="fl center mr15"><a href="#" class="carmine">All</a></li>
			<li class="fl center">/</li>
			<li class="fl center ml15 mr15"><a href="#" class="light-red">Offers</a></li>
			<li class="fl center">/</li>
			<li class="fl center ml15 mr15"><a href="#" class="light-red">Needs</a></li>
			<li class="fl center">/</li>
			<li class="fl center ml15 "><a href="#" class="light-red">Event</a></li>
			<li class="clear"></li>
		</ul>
		<hr />
		<div class="clear mt50">
			<div class="clear">
				<img class="avatar fl" src="" />
				<div class="intro w500 fl ml15">
					<span class="arial blue font24 b">#username</span>
					<p class="verdana font18">啊啊啊</p>
					<ul class="black arial font18 mt15">
						<li class="fl tag">IT<a>star</a></li>
						<li class="fl tag">O<a>star</a></li>
						<li class="fl tag">Medicine<a>star</a></li>
						<li class="fl tag">Event<a>star</a></li>
					</ul>
				</div>
				
				<a href="#" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow">follow</a>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".main-navi").toggle(function(){
			$(".sub").slideDown();
		}, function(){
			$(".sub").slideUp();
		});
	});
</script>

<?php include("footer.php"); ?>