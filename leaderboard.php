<?php
require_once('header.php');
$_SESSION['page'] = 'leaderboard';
// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
// fetch all records and order by xp in descending order
$data = $conn->query("SELECT username, xp, xplevel FROM users ORDER BY xp DESC")->fetch_all();
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
				<p class="float-left"><span class="bg-primary my-1 mr-2 px-2 py-1 rounded"><?php if (isset($_SESSION['username'])){ echo $user; } else { echo '1';} ?></span><span class="text-light my-1 px-2 py-1 rounded-left" style="background-color:#222"><?php echo $data[$user][2]; ?></span><span class="py-1 my-1 px-3 rounded-right" style="background-color:#888"><?php echo $data[$user][0]; ?></span></p>
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
		echo '<div class="row">
				<div class="col-sm"></div>
				<div class="col-sm '; 
					// show the logged in user's entry as yellow but all others as grey
					if ($data[$i-1][0] == $_SESSION['username']){
						echo 'bg-warning';
					} else {
						echo 'bg-dark';
					}
					echo ' rounded my-1 p-1 mx-1">
					<p class="float-left"><span class="bg-primary my-1 mr-1 px-2 rounded">' . 
						$i . '</span><span class="text-light my-1 px-2 rounded-left" style="background-color:#222">' . $data[$i-1][2] . '</span><span class="my-1 px-3 rounded-right" style="background-color:#888">' . $data[$i-1][0] . '</span>
					</p>
					<p class="float-right rounded bg-success px-2">' . 
						$data[$i-1][1] . '
					</p>
				</div>
				<div class="col-sm"></div>';
			echo '</div>';
	}
	?>
</div>