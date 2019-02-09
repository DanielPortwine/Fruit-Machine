<?php
require_once('header.php');
$_SESSION['page'] = 'play';

// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';

// if user is not logged in redirect to login page
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index";</script>';
}

// if user is DanPortwine show admin nav
if (isset($_SESSION['username']) && $_SESSION['username'] === 'DanPortwine'){
    echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom">
        <span class="navbar-brand">Admin controls</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent1" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent1">
            <ul class="navbar-nav mr-auto">
                <!-- play -->
                <li><button class="nav-item btn btn-success m-1" id="adminSpins">+20 Spins</button></li>
                <li><button class="nav-item btn btn-success m-1" id="adminBeers">+10 Beers</button></li>
                <li>
                    <form class=" m-1">
                        <input class="itemEntry" id="rItem1" type="number" min="0" max="13">
                        <input class="itemEntry" id="rItem2" type="number" min="0" max="13">
                        <input class="itemEntry" id="rItem3" type="number" min="0" max="13">
                        <input class="itemEntry" id="rItem4" type="number" min="0" max="13">
                        <input class="itemEntry" id="rItem5" type="number" min="0" max="13">
                        <input class="btn btn-success" type="button" id="spinButtonRigged" value="SPIN">
                    </form>
                </li>
                <li><button class="nav-item btn btn-success m-1" id="adminSimulateSpins">1000 spins</button></li>
            </ul>
        </div>
    </nav>';
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