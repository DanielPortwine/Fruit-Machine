<?php
require_once('header.php');
$_SESSION['page'] = 'leaderboard';

// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';

// fetch all records and order by xp in descending order
$query = $conn->query("SELECT username, score, xp, xplevel, spins, verified FROM users ORDER BY score DESC");
$data = [];
while ($user = $query->fetch_array(MYSQLI_ASSOC)) {
    if ($user['verified'] == 1) {
        array_push($data, $user);
    }
}
// find the number of records
$count = sizeOf($data);
if (isset($_SESSION['username'])){
	for ($i=1;$i<=$count;$i++){
		if ($data[$i-1]['username'] == $_SESSION['username']){
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
				<p class="float-left"><span class="bg-primary my-1 mr-2 px-2 py-1 rounded"><?= isset($_SESSION['username']) ? $user+1 : '1' ?></span><span class="text-light my-1 px-2 py-1 rounded-left" style="background-color:#222"><?= $data[$user]['xplevel'] ?></span><span class="py-1 my-1 px-3 rounded-right" style="background-color:#888"><?= $data[$user]['username'] ?></span></p>
				<p class="float-right rounded bg-success px-2"><?= $data[$user]['score']; ?></p>
			</div>
			<div class="col-sm"></div>
		</div>
</div>

<div class="container text-center my-5">
<hr>
	<?php
	// display the user data for every user
	for ($i=1;$i<=$count;$i++){
		$username = $data[$i-1]['username'];
		$score = $data[$i-1]['score'];
		$xp = $data[$i-1]['xp'];
		$level = $data[$i-1]['xplevel'];
		$spins = $data[$i-1]['spins']; ?>
		<div class="row">
				<div class="col-sm"></div>
				<div class="col-sm <?= $username == $_SESSION['username'] ? 'bg-warning' : 'bg-dark' ?> rounded my-1 p-1 mx-1">
					<p class="float-left"><span class="bg-primary my-1 mr-1 px-2 rounded"><?= $i ?></span><span class="text-light my-1 px-2 rounded-left" style="background-color:#222"><?= $level ?></span><span class="my-1 px-3 rounded-right" style="background-color:#888"><?= $username ?></span></p>
					<p class="float-right rounded bg-success px-2 ml-2"><?= $score ?></p>
					<?php /*if (isset($_SESSION['username']) && $_SESSION['username'] == 'DanPortwine'){ */?><!--
						<p class="float-right rounded bg-success px-2 ml-2"><?/*= $spins */?></p>
					--><?php /*} */?>
				</div>
				<div class="col-sm"></div>
			</div>
	<?php } ?>
</div>