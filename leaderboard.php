<?php
require_once('header.php');
$_SESSION['page'] = 'leaderboard';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
if (empty($_SESSION['username'])) {
	echo '<script>window.location = "index.php";</script>';
}
$dataXp = $conn->query("SELECT username, xp, xplevel, points FROM users ORDER BY xp DESC")->fetch_all();
$dataPoints = $conn->query("SELECT username, xp, xplevel, points FROM users ORDER BY points DESC")->fetch_all();
$count = sizeOf($dataXp);
?>
<div class="container text-center my-5">
	<div class="row">
		<div class="col-sm">
			<h2>XP</h2>
			<hr>
		</div>
		<div class="col-sm">
			<h2>Points</h2>
			<hr>
		</div>
	</div>
	<?php
	for ($i=1;$i<=$count;$i++){
		echo '<div class="row">
				<div class="col-sm">
					<p class="float-left">' . 
						$i . '. ' . $dataXp[$i-1][0] . ' (' . $dataXp[$i-1][2] . ')
					</p>
					<p class="float-right">' . 
						$dataXp[$i-1][1] . '
					</p>
				</div>
				<div class="col-sm">
					<p class="float-left">' . 
						$i . '. ' . $dataPoints[$i-1][0] . ' (' . $dataPoints[$i-1][2] . ')
					</p>
					<p class="float-right">' . 
						$dataPoints[$i-1][3] . '
					</p>
				</div>
			</div>';
	}
	?>
</div>