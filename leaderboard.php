<?php
require_once('header.php');
$_SESSION['page'] = 'leaderboard';
// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
// fetch all records and order by xp in descending order
$query = $conn->query("SELECT username, score, xp, xplevel, spins FROM users ORDER BY score DESC");
$data = [];
while ($user = $query->fetch_array(MYSQLI_NUM)) {
    array_push($data,$user);
}
// find the number of records
$count = sizeOf($data);
if (isset($_SESSION['username'])){
	for ($i=1;$i<=$count;$i++){
		if ($data[$i-1][0] == $_SESSION['username']){
			$user = $i-1;
			break;
		}
	}
} else {
	$user = 0;
}
?>
<div class="container text-center my-5">
		<div class="row">
			<div class="col-sm"></div>
			<div class="col-sm bg-warning rounded my-1 py-2 px-3 mx-1">
				<p class="float-left"><span class="bg-primary my-1 mr-2 px-2 py-1 rounded"><?php if (isset($_SESSION['username'])){ echo $user+1; } else { echo '1';} ?></span><span class="text-light my-1 px-2 py-1 rounded-left" style="background-color:#222"><?php echo $data[$user][3]; ?></span><span class="py-1 my-1 px-3 rounded-right" style="background-color:#888"><?php echo $data[$user][0]; ?></span></p>
				<p class="float-right rounded bg-success px-2"><?php echo $data[$user][1]; ?></p>
			</div>
			<div class="col-sm"></div>
		</div>
</div>
<div class="container text-center my-5">
<hr>
	<?php
	// display the user data for every user
	for ($i=1;$i<=$count;$i++){
		$username = $data[$i-1][0];
		$score = $data[$i-1][1];
		$xp = $data[$i-1][2];
		$level = $data[$i-1][3];
		$spins = $data[$i-1][4];
		echo '<div class="row">
				<div class="col-sm"></div>
				<div class="col-sm '; 
					// show the logged in user's entry as yellow but all others as grey
					if ($username == $_SESSION['username']){
						echo 'bg-warning';
					} else {
						echo 'bg-dark';
					}
					echo ' rounded my-1 p-1 mx-1">
					<p class="float-left"><span class="bg-primary my-1 mr-1 px-2 rounded">' . 
						$i . '</span><span class="text-light my-1 px-2 rounded-left" style="background-color:#222">' . $level . '</span><span class="my-1 px-3 rounded-right" style="background-color:#888">' . $username . '</span>
					</p>
					<p class="float-right rounded bg-success px-2 ml-2">' . 
						$score . '
					</p>';
					if ($_SESSION['username'] == 'Dan'){
						echo '
						<p class="float-right rounded bg-success px-2 ml-2">' . 
							$spins . '
						</p>';
					}
				echo '
				</div>
				<div class="col-sm"></div>
			</div>';
	}
	?>
</div>