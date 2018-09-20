<?php
require_once('header.php');
$_SESSION['page'] = 'play';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
?>
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
			<button class="btn btn-success ml-auto mr-auto mt-2" id="spinButton">SPIN</button>
		</div>
	</div>
</div>