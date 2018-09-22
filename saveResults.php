<?php
session_start();
require_once('connection.php');
$result = $_POST['result'];
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
$xp = $userData[8];
$spins = $userData[11];
$nothings = $userData[16];
$twos = $userData[15];
$threes = $userData[14];
$fours = $userData[13];
$fives = $userData[12];

$xp++;
$spins++;

$items = scandir('images/items');
unset($items[0]);
unset($items[1]);
$itemsCount = [];
foreach ($items as $item){
	array_push($itemsCount,0);
}
for ($i=0;$i<=sizeOf($items);$i++){
	foreach ($_POST['result'] as $result){
		if ($result == $i){
			$itemsCount[$result]++;
		}
	}
}
$patternFound = false;
foreach ($itemsCount as $count){
	if ($count == 2){
		$twos++;
		$xp += 10;
		$patternFound = true;
	} else if ($count == 3){
		$threes++;
		$xp += 50;
		$patternFound = true;
	} else if ($count == 4){
		$fours++;
		$xp += 75;
		$patternFound = true;
		break;
	} else if ($count == 5){
		$fives++;
		$xp += 100;
		$patternFound = true;
		break;
	}
}
if (!$patternFound){
	$nothings++;
}
$xpLevel = floor($xp/1000);
$conn->query("UPDATE users SET xp={$xp},xpLevel={$xpLevel},spins={$spins},nothings={$nothings},twos={$twos},threes={$threes},fours={$fours},fives={$fives} WHERE username = '{$_SESSION['username']}';");
?>