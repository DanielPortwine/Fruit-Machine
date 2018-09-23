<?php
require_once('header.php');
$_SESSION['page'] = 'stats';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
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
		<div class="row">
			<div class="col-sm px-0" style="border:solid 1px #000">
				<div style="background-color:#090;height:100%;width:<?php echo 100 - ((floor(($xp+1000)/1000)*1000 - $xp)/10) ?>%;">
					<?php 
					if ($xp < 10){
						echo substr($xp,-1);
					} else if ($xp < 100) {
						echo substr($xp,-2,2);
					} else {
						echo substr($xp,-3,3);
					}
					?>/1000
				</div>
			</div>
		</div>
		<div class="row">
			<h4 class="col-sm text-left"><?php echo $level; ?></h4>
			<h4 class="col-sm text-right"><?php echo $level + 1; ?></h4>
		</div>
		<div class="row">
			<p class="col-sm text-right">Total spins:</p>
			<p class="col-sm text-left"><?php echo $spins; ?></p>
		</div>
		<div class="row">
			<p class="col-sm text-right">Fives:</p>
			<p class="col-sm text-left"><?php echo $fives; ?></p>
		</div>
		<div class="row">
			<p class="col-sm text-right">Fours:</p>
			<p class="col-sm text-left"><?php echo $fours; ?></p>
		</div>
		<div class="row">
			<p class="col-sm text-right">Threes:</p>
			<p class="col-sm text-left"><?php echo $threes; ?></p>
		</div>
		<div class="row">
			<p class="col-sm text-right">Doubles:</p>
			<p class="col-sm text-left"><?php echo $twos; ?></p>
		</div>
		<div class="row">
			<p class="col-sm text-right">Singles:</p>
			<p class="col-sm text-left"><?php echo $nothings; ?></p>
		</div>
		<div class="row">
			<p class="col-sm text-right">Date joined:</p>
			<p class="col-sm text-left"><?php echo substr(date('d/m/Y H:i:s',$dateJoined),0,16); ?></p>
		</div>
	</div>
</div>