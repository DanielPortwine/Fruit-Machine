<?php
require_once('header.php');
$_SESSION['page'] = 'play';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
?>
<h3 class="text-center w-100 mt-5" id="xpGainedContainer"><span class="rounded alert-success p-3 mt-5" id="xpGained"></span></h3>
<div class="vertical-center">
	<div class="container text-center mb-5">
		<div class="row">
			<div class="col-sm">
				<img class="itemImage" id="item1" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage" id="item2" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage" id="item3" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage" id="item4" src="images/begin.png">
			</div>
			<div class="col-sm">
				<img class="itemImage" id="item5" src="images/begin.png">
			</div>
		</div>
		<div class="row">
			<p class="col-sm my-2">Spins remaining: <span id="spinsLeft"></span></p>
		</div>
		<div class="row">
			<button class="btn btn-lg btn-success mx-auto mt-2" id="spinButton">SPIN</button>
		</div>
		<div class="row">
			<button class="btn btn-lg btn-success mx-auto mt-2" id="dailySpinButton">+20 spins<sub><span id="dailySpinTimeRemaining"></span></sub></button>
		</div>
		<!--<div class="row">
			<div class="ml-auto mr-auto mt-5" id="allItems"></div>
		</div>-->
	</div>
</div>