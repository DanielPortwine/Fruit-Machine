<?php
require_once('header.php');
$_SESSION['page'] = 'play';
// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
// if user is not logged in redirect to login page
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
?>
<!-- show the amount of xp gained by the spin -->
<h3 class="text-center w-100 mt-5" id="xpGainedContainer"><span class="rounded alert-success p-3 mt-5" id="xpGained"></span></h3>
<div class="vertical-center">
	<div class="container text-center mb-5">
		<!-- items row -->
		<div class="row">
			<div class="col-sm">
				<img class="itemImage m-1" id="item1" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage m-1" id="item2" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage m-1" id="item3" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage m-1" id="item4" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage m-1" id="item5" src="images/begin.png">
			</div>
		</div>
		<!-- How many spins left -->
		<div class="row">
			<p class="col-sm my-2">Spins left: <span id="spinsLeft"></span> | Beer left: <span id="beersLeft"></span> | Beer spins left: <span id="beerSpinsLeft"></span></p>
		</div>
		<!-- spin button -->
		<div class="row">
			<button class="btn btn-lg btn-success mx-auto p-3 px-4" id="spinButton"><i class="fa fa-rotate-right" style="font-size:50px;"></i></button>
		</div>
		<!-- Beer button -->
		<div class="row">
			<button class="btn btn-lg btn-success mx-auto mt-2" id="beerButton"><img src="images/items/gulhhess.png"></img></button>
		</div>
		<!-- extra spins button -->
		<div class="row">
			<button class="btn btn-lg btn-success mx-auto mt-2" id="dailySpinButton">+20 spins<sub><span id="dailySpinTimeRemaining"></span></sub></button>
		</div>
	</div>
</div>