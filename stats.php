<?php
require_once('header.php');
$_SESSION['page'] = 'stats';
// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
// if user is not logged in redirect to login page
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
// fetch data from logged in user's record
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
// assign more relevant variable names for user's data
$spinsLeft = $userData[7];
$xp = $userData[9];
$level = $userData[10];
$spins = $userData[12];
$nothings = $userData[17];
$twos = $userData[16];
$threes = $userData[15];
$fours = $userData[14];
$fives = $userData[13];
$dateJoined = strtotime($userData[6]);
$email = $userData[2];
?>
<div class="vertical-center">
	<div class="container text-center mb-5">
		<h1><?php echo $_SESSION['username']; ?></h1>
		<p><?php echo $email; ?></p>
		<hr>
		<div class="row">
			<!-- progress bar showing how far they are from the next level -->
			<div class="progress col-sm px-0 mx-1" style="border:solid 1px #000">
				<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:<?php echo 100 - ((floor(($xp+1000)/1000)*1000 - $xp)/10) ?>%;">
					<?php 
					if ($xp < 10){
						echo substr($xp,-1);
					} else if ($xp < 100) {
						echo substr($xp,-2,2);
					} else {
						echo intval(substr($xp,-3,3));
					}
					?>/1000
				</div>
			</div>
		</div>
		<div class="row">
			<h4 class="col-sm text-left"><?php echo $level; ?>
			<span class="float-right"><?php echo $level + 1; ?></span></h4>
		</div>
		<table class="table table-borderless">
			<tr>
				<td class="text-right p-1">Total spins:</td>
				<td class="text-left p-1"><?php echo $spins; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Quintuples:</td>
				<td class="text-left p-1"><?php echo $fives; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Quadruples:</td>
				<td class="text-left p-1"><?php echo $fours; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Triples:</td>
				<td class="text-left p-1"><?php echo $threes; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Doubles:</td>
				<td class="text-left p-1"><?php echo $twos; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">No matches:</td>
				<td class="text-left p-1"><?php echo $nothings; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Date joined:</td>
				<td class="text-left p-1"><?php echo substr(date('d/m/Y H:i:s',$dateJoined),0,16); ?></p>
			</tr>
		</table>
	</div>
</div>