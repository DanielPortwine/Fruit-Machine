<?php
require_once('header.php');

$_SESSION['page'] = 'stats';

// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';

// if user is not logged in redirect to login page
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index";</script>';
}

// fetch data from logged in user's record
$userData = mysqli_fetch_row($conn->query("SELECT spinsLeft,score,xp,xpLevel,beers,beerSpinsLeft,beersUsed,spins,fives,fours,threes,twos,nothings,dateCreated,email,bombs FROM users WHERE username = '{$_SESSION['username']}';"));
// assign more relevant variable names for user's data
$spinsLeft = $userData[0];
$score = $userData[1];
$xp = $userData[2];
$level = $userData[3];
$beersCurrent = $userData[4];
$beerSpinsLeft = $userData[5];
$beersTotal = $userData[6];
$spins = $userData[7];
$nothings = $userData[12];
$twos = $userData[11];
$threes = $userData[10];
$fours = $userData[9];
$fives = $userData[8];
$dateJoined = strtotime($userData[13]);
$email = $userData[14];
$bombs = $userData[15];
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
				<td class="text-left p-1"><?php echo $spins; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Total XP:</td>
				<td class="text-left p-1"><?php echo $xp; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Score:</td>
				<td class="text-left p-1"><?php echo $score ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Current beer:</td>
				<td class="text-left p-1"><?php echo $beersCurrent ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Spins left with beer bonus:</td>
				<td class="text-left p-1"><?php echo $beerSpinsLeft ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Total beer used:</td>
				<td class="text-left p-1"><?php echo $beersTotal ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Spins exploded:</td>
				<td class="text-left p-1"><?php echo $bombs ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Quintuples:</td>
				<td class="text-left p-1"><?php echo $fives; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Quadruples:</td>
				<td class="text-left p-1"><?php echo $fours; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Triples:</td>
				<td class="text-left p-1"><?php echo $threes; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Doubles:</td>
				<td class="text-left p-1"><?php echo $twos; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">No matches:</td>
				<td class="text-left p-1"><?php echo $nothings; ?></td>
			</tr>
			<tr>
				<td class="text-right p-1">Date joined:</td>
				<td class="text-left p-1"><?php echo substr(date('d/m/Y H:i:s',$dateJoined),0,16); ?></td>
			</tr>
		</table>
	</div>
</div>