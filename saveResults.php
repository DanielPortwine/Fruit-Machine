<?php
session_start();
require_once('connection.php');
// assign result to more relevant variable name
$result = $_POST['result'];
// fetch all data for logged in user
$userData = mysqli_fetch_row($conn->query("SELECT * FROM users WHERE username = '{$_SESSION['username']}';"));
$spinsLeft = $userData[7];
$xp = $userData[10];
$originalXP = $xp;
$spins = $userData[13];
$nothings = $userData[18];
$twos = $userData[17];
$threes = $userData[16];
$fours = $userData[15];
$fives = $userData[14];
// if the user has spins decrement them
if ($spinsLeft > 0){
	$spinsLeft--;
}
// increment total spins
$spins++;
// scan items directory of item images
$items = scandir('images/items');
// remove '.' and '..' elements from array
unset($items[0]);
unset($items[1]);
// initialise an array as large as the number of items with eac hvalue at 0
$itemsCount = [];
foreach ($items as $item){
	array_push($itemsCount,0);
}
// go through each item
for ($i=0;$i<=sizeOf($items);$i++){
	foreach ($result as $res){
		// if the item has been generated increment corresponding element in count array
		if ($res == $i){
			$itemsCount[$res]++;
		}
	}
}
// detect whether any matches have been generated
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
		$xp += 250;
		$patternFound = true;
		break;
	} else if ($count == 5){
		$fives++;
		$xp += 10000;
		$patternFound = true;
		break;
	}
}
if (!$patternFound){
	$nothings++;
	$xp += 5;
}
// calculate xp gained in this spin
$gainedXP = $xp - $originalXP;
echo $gainedXP;
$xp++;
// calculate user's level
$xpLevel = floor($xp/1000);
// calculate user's  score
$score = floor(($xp / $spins) + floor($xpLevel * 0.3));
// update user's record
$conn->query("UPDATE users SET score={$score},xp={$xp},xpLevel={$xpLevel},spins={$spins},spinsLeft={$spinsLeft},nothings={$nothings},twos={$twos},threes={$threes},fours={$fours},fives={$fives} WHERE username = '{$_SESSION['username']}';");
?>