<?php
session_start();
require_once('connection.php');
$result = $_POST['result'];
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
$spinsLeft = $userData[7];
$xp = $userData[9];
$originalXP = $xp;
$spins = $userData[12];
$nothings = $userData[17];
$twos = $userData[16];
$threes = $userData[15];
$fours = $userData[14];
$fives = $userData[13];

if ($spinsLeft > 0){
	$spinsLeft--;
}
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
		$xp += 100;
		$patternFound = true;
		break;
	} else if ($count == 5){
		$fives++;
		$xp += 500;
		$patternFound = true;
		break;
	}
}
if (!$patternFound){
	$nothings++;
}
$gainedXP = $xp - $originalXP;
echo $gainedXP;
$xpLevel = floor($xp/1000);
$conn->query("UPDATE users SET xp={$xp},xpLevel={$xpLevel},spins={$spins},spinsLeft={$spinsLeft},nothings={$nothings},twos={$twos},threes={$threes},fours={$fours},fives={$fives} WHERE username = '{$_SESSION['username']}';");
?>