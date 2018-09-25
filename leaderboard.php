<?php
require_once('header.php');
$_SESSION['page'] = 'leaderboard';
// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
// fetch all records and order by xp in descending order
$dataXp = $conn->query("SELECT username, xp, xplevel, points FROM users ORDER BY xp DESC")->fetch_all();
// fin dthe number of records
$count = sizeOf($dataXp);
?>
<div class="container text-center my-5">
	<?php
	// display the user data for every user
	for ($i=1;$i<=$count;$i++){
		echo '<div class="row">
				<div class="col-sm"></div>
				<div class="col-sm '; 
					// show the logged in user's entry as yellow but all others as grey
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