<?php
require_once('header.php');
$_SESSION['page'] = 'admin';
// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
// if user is not logged in or not admin redirect to login page
if (empty($_SESSION['username']) || $_SESSION['username'] != 'Dan') {
	echo '<script>window.location = "index.php";</script>';
}
$totalUsers = mysqli_num_rows($conn->query("SELECT userID FROM users"));
$spinsTotal = 0;
$xpTotal = 0;
$fivesTotal = 0;
$foursTotal = 0;
$threesTotal = 0;
$twosTotal = 0;
$nothingsTotal = 0;
$data = [];
for ($i=1;$i<$totalUsers+1;$i++){
	$row = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE userID = {$i}"));
	array_push($data,$row);
	$spinsTotal += $row[12];
	$xpTotal += $row[9];
	$fivesTotal += $row[13];
	$foursTotal += $row[14];
	$threesTotal += $row[15];
	$twosTotal += $row[16];
	$nothingsTotal += $row[17];
}
$spinsAvg = round($spinsTotal / $totalUsers,2);
$xpAvg = round($xpTotal / $totalUsers,2);
$fivesAvg = round($fivesTotal / $totalUsers,2);
$foursAvg = round($foursTotal / $totalUsers,2);
$threesAvg = round($threesTotal / $totalUsers,2);
$twosAvg = round($twosTotal / $totalUsers,2);
$nothingsAvg = round($nothingsTotal / $totalUsers,2);

$oldest = $conn->query("SELECT username, xplevel, dateCreated FROM users ORDER BY dateCreated ASC LIMIT 10")->fetch_all();
$countOld = sizeOf($oldest);
$youngest = $conn->query("SELECT username, xplevel, dateCreated FROM users ORDER BY dateCreated DESC LIMIT 10")->fetch_all();
$countYoung = sizeOf($youngest);
?>
<div class="vertical-center">
	<div class="container text-center mb-5">
		<table class="table table-borderless">
			<tr>
				<td class="text-right p-1"><h3>Total users:</h3></td>
				<td class="text-left p-1"><h3><?php echo $totalUsers; ?></h3></p>
			</tr>
			<tr>
				<td class="text-right p-1">Total spins:</td>
				<td class="text-left p-1"><?php echo $spinsTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average spins:</td>
				<td class="text-left p-1"><?php echo $spinsAvg; ?></p>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="text-right p-1">Total xp:</td>
				<td class="text-left p-1"><?php echo $xpTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average xp:</td>
				<td class="text-left p-1"><?php echo $xpAvg; ?></p>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="text-right p-1">Total Quintuples:</td>
				<td class="text-left p-1"><?php echo $fivesTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average Quintuples:</td>
				<td class="text-left p-1"><?php echo $fivesAvg; ?></p>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="text-right p-1">Total Quadruples:</td>
				<td class="text-left p-1"><?php echo $foursTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average Quadruples:</td>
				<td class="text-left p-1"><?php echo $foursAvg; ?></p>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="text-right p-1">Total Triples:</td>
				<td class="text-left p-1"><?php echo $threesTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average Triples:</td>
				<td class="text-left p-1"><?php echo $threesAvg; ?></p>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="text-right p-1">Total Doubles:</td>
				<td class="text-left p-1"><?php echo $twosTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average Doubles:</td>
				<td class="text-left p-1"><?php echo $twosAvg; ?></p>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="text-right p-1">Total No matches:</td>
				<td class="text-left p-1"><?php echo $nothingsTotal; ?></p>
			</tr>
			<tr>
				<td class="text-right p-1">Average No matches:</td>
				<td class="text-left p-1"><?php echo $nothingsAvg; ?></p>
			</tr>
		</table>
		<hr>
		<h4>Oldest 10 users</h4>
		<div class="row">
			<?php
			for ($i=1;$i<=$countOld;$i++){
				if (($i + 1) % 2 == 0){
					echo '<div class="w-100"></div>';
				}
				echo '<div class="col-sm rounded my-1 p-1 mx-1 bg-dark">
					<p class="float-left"><span class="bg-primary my-1 mr-1 px-2 rounded">' . $i . '</span><span class="text-light my-1 px-2 rounded-left" style="background-color:#222">' . $oldest[$i-1][1] . '</span><span class="my-1 px-3 rounded-right" style="background-color:#888">' . $oldest[$i-1][0] . '</span>
					</p>
					<p class="float-right rounded bg-success px-2">' . 
						date('d/m/Y',strtotime($oldest[$i-1][2])) . '
					</p>
				</div>';
			}
			?>
		</div>
		<hr>
		<h4>Youngest 10 users</h4>
		<div class="row">
			<?php
			for ($i=1;$i<=$countYoung;$i++){
				if (($i + 1) % 2 == 0){
					echo '<div class="w-100"></div>';
				}
				echo '<div class="col-sm rounded my-1 p-1 mx-1 bg-dark">
					<p class="float-left"><span class="bg-primary my-1 mr-1 px-2 rounded">' . $i . '</span><span class="text-light my-1 px-2 rounded-left" style="background-color:#222">' . $youngest[$i-1][1] . '</span><span class="my-1 px-3 rounded-right" style="background-color:#888">' . $youngest[$i-1][0] . '</span>
					</p>
					<p class="float-right rounded bg-success px-2">' . 
						date('d/m/Y',strtotime($youngest[$i-1][2])) . '
					</p>
				</div>';
			}
			?>
		</div>
	</div>
</div>