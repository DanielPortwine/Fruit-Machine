<?php
require_once('header.php');
$_SESSION['page'] = 'play';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
?>
<div class="vertical-center">
	<div class="container text-center">
	  <div class="row">
		<div class="col-sm">
		  <img src="images/pineapple.png">
		</div>
		<div class="col-sm">
		  <img src="images/strawberry.png">
		</div>
		<div class="col-sm">
		  <img src="images/pineapple.png">
		</div>
		<div class="col-sm">
		  <img src="images/strawberry.png">
		</div>
		<div class="col-sm">
		  <img src="images/pineapple.png">
		</div>
	  </div>
	</div>
</div>