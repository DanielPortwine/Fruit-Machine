<?php
session_start();
require_once('connection.php');
// assign result to more relevant variable name
$result = $_POST['result'];
// fetch all data for logged in user
$userData = mysqli_fetch_row($conn->query("SELECT spinsLeft,xp,beers,beerSpinsLeft,spins,fives,fours,threes,twos,nothings,bombs FROM users WHERE username = '{$_SESSION['username']}';"));
$spinsLeft = $userData[0];
$xp = $userData[1];
$gainedXP = 0;
$beers = $userData[2];
$beerSpinsLeft = $userData[3];
$spins = $userData[4];
$nothings = $userData[9];
$twos = $userData[8];
$threes = $userData[7];
$fours = $userData[6];
$fives = $userData[5];
$bombs = $userData[10];
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
// initialise an array as large as the number of items with each value at 0
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
// find how many Beers were spun
$beers += $itemsCount[7];
// find out how many bombs were spun
$bombsSpun = $itemsCount[4];
if ($bombsSpun > 0){
	$gainedXP = 0;
	$bombs++;
	// account for Beer xp bonus
	if ($beerSpinsLeft > 0){
		$beerSpinsLeft--;
	}
	if ($bombsSpun == 1){
		$beers = ceil($beers * 0.8);
	} else if ($bombsSpun == 2){
		$beers = floor($beers * 0.8);
	} else if ($bombsSpun == 3){
		$beers = floor($beers * 0.5);
	} else if ($bombsSpun == 4){
		$beers = floor($beers * 0.2);
	} else if ($bombsSpun == 5){
		$beers = 0;
	}
} else {
	// detect whether any matches have been generated
	$patternFound = false;
	foreach ($itemsCount as $count){
		if ($count == 2){
			$twos++;
			$gainedXP += 10;
			$patternFound = true;
		} else if ($count == 3){
			$threes++;
			$gainedXP += 50;
			$patternFound = true;
		} else if ($count == 4){
			$fours++;
			$gainedXP += 250;
			$patternFound = true;
			break;
		} else if ($count == 5){
			$fives++;
			$gainedXP += 5000;
			$patternFound = true;
			break;
		}
	}
	if (!$patternFound){
		$nothings++;
		$gainedXP += 5;
	}
	// account for Beer xp bonus
	if ($beerSpinsLeft > 0){
		$gainedXP *= 2;
		$beerSpinsLeft--;
	}
}
echo $gainedXP;
$gainedXP++;
$xp += $gainedXP;
// calculate user's level
$xpLevel = floor($xp/1000);
// calculate user's  score
$score = floor(($xp / $spins) + floor($xpLevel * 0.3));
// update user's record
$conn->query("UPDATE users SET score={$score},xp={$xp},xpLevel={$xpLevel},beers={$beers},beerSpinsLeft={$beerSpinsLeft},spins={$spins},spinsLeft={$spinsLeft},nothings={$nothings},twos={$twos},threes={$threes},fours={$fours},fives={$fives} WHERE username = '{$_SESSION['username']}';");
?>