<?php require_once("../common.php"); ?>

<html>
    <head>
		<meta http-equiv="Content-Type"content="text/html; charset=utf-8" />
		<link style="text/css" href="../css/base.css" rel="stylesheet"/>
		<link style="text/css" href="../css/page.css" rel="stylesheet"/>
    </head>
    <body>
		<div class="bg-white">
		<div class="wrap">
			<div id="welcome" class="fr font18 pr10 arial light-red">
				Welcome <a href="#" class="blue b">#username</a>, 
				<a href="#" class="arial carmine b">logout</a>
			</div>
			<div class="p20">
				<img src="../image/omarhub-logo.png" width="96" class="mb-15"/>
				<span id="omar" class="georgia"><b>Omar</b></span>
				<span id="hub" class="georgia"><b>Hub</b></span>
			</div>
		</div>
		</div>
	
		<div id="navi_wrap" class="navi-bg">
			<div id="navi" class="wrap shadow">
				<ul class="w700 fl b font24">
				<li class="fl center pl20 pr20 main-navi"><a href="#" class="gray">PROFILE</a></li>
				<li class="fl center pl20 pr20 main-navi-active"><a href="#" class="white">PEOPLE & ACTIVITY</a></li>
				<li class="fl center pl20 pr20 main-navi"><a href="#" class="gray">TAGS</a></li>
				<li class="fl center pl20 pr20 main-navi"><a href="#" class="gray">CREATE</a></li>
				<li class="clear"></li>
			</ul>
			<div id="search" class="fr pr20">
				<input type="text">
				<img src="../image/Find.png" width="35px" class="find">
			</div>
			<div class="clear"></div>
			</div>
			<div class="clear">
		</div>
		</div>
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
		<div id="footer" class="bg-darkblue">
			<div class="wrap">
				<div class="center p5 blue font18">Copyright&copy;2012, <b>4.5</b> Team. All rights reserved.</div>
			</div>
		</div>
    </body>
    <script type="text/javascript" src="../script/jquery-1.7.2.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
	    $(".main-navi").toggle(function(){
	        $(".sub").slideDown();
	    }, function(){
	        $(".sub").slideUp();
	    });
	});   
   </script>
</html>