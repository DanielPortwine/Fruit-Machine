<?php
require_once('header.php');
$_SESSION['page'] = 'leaderboard';
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
$dataXp = $conn->query("SELECT username, xp, xplevel, points FROM users ORDER BY xp DESC")->fetch_all();
$dataPoints = $conn->query("SELECT username, xp, xplevel, points FROM users ORDER BY points DESC")->fetch_all();
$count = sizeOf($dataXp);
?>
<div class="container text-center my-5">
	<?php
	for ($i=1;$i<=$count;$i++){
		echo '<div class="row">
				<div class="col-sm"></div>
				<div class="col-sm '; 
					if ($dataXp[$i-1][0] == $_SESSION['username']){
						echo 'bg-warning';
					} else {
						echo 'bg-dark';
					}
					echo ' rounded my-1 p-1 mx-1">
					<p class="float-left"><span class="bg-primary my-1 mr-1 px-2 rounded">' . 
						$i . '</span><span class="text-light my-1 px-2 rounded-left" style="background-color:#222">' . $dataXp[$i-1][2] . '</span><span class="my-1 px-3 rounded-right" style="background-color:#888">' . $dataXp[$i-1][0] . '</span>
					</p>
					<p class="float-right rounded bg-success px-2">' . 
						$dataXp[$i-1][1] . '
					</p>
				</div>
				<div class="col-sm"></div>';
			echo '</div>';
	}
	?>
</div>