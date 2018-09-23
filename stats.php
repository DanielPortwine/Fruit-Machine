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
			<h4 class="col-sm text-left"><?php echo $level; ?>
			<span class="float-right"><?php echo $level + 1; ?></span></h4>
		</div>
		
		<table class="table table-borderless">
			<tr>
				<td class="text-right p-1">Total spins:</td>
				<td class="text-left p-1"><?php echo $spins; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Five of a kind:</td>
				<td class="text-left p-1"><?php echo $fives; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Four of a kind:</td>
				<td class="text-left p-1"><?php echo $fours; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Three of a kind:</td>
				<td class="text-left p-1"><?php echo $threes; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Doubles:</td>
				<td class="text-left p-1"><?php echo $twos; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Singles:</td>
				<td class="text-left p-1"><?php echo $nothings; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Date joined:</td>
				<td class="text-left p-1"><?php echo substr(date('d/m/Y H:i:s',$dateJoined),0,16); ?></p>
			</tr>
		</table>
	</div>
</div>