<?php
session_start();
require_once('connection.php');
// scan items directory of item images
$items = scandir('images/items');
// remove '.' and '..' elements from array
unset($items[0]);
unset($items[1]);
// if user has spins generate 5 random numbers corresponding to items in the items directory
if (mysqli_fetch_row($conn->query("SELECT spinsLeft FROM users WHERE username = '{$_SESSION['username']}';"))[0] > 0){
	$minute = date('i');
	$second = date('s');
	if (($minute == 20 && $second == 18) || ($minute == 13 && $second == 13)){
		$availableItems = [];
		for ($i=0;$i<mt_rand(3,8);$i++){
			$item = mt_rand(0,sizeOf($items)-1);
			if ($item != 4){
				array_push($availableItems,$item);
			} else{
				array_push($availableItems,7);
			}
		}
		for ($i=0;$i<4;$i++){
			echo $availableItems[mt_rand(0,sizeOf($availableItems)-1)] . ',';
		}
		echo $availableItems[mt_rand(0,sizeOf($availableItems)-1)];
	} else {
		for ($i=0;$i<4;$i++){
			$item = mt_rand(0,sizeOf($items)-1);
			if ($items[$item+2] == 'plus5Spin.png' || $items[$item+2] == 'plus1Spin.png'){
				$item = mt_rand(0,sizeOf($items)-1);
			} else if ($items[$item+2] == 'plus10Spin.png'){
				$item = mt_rand(0,sizeOf($items)-1);
				if ($items[$item+2] == 'plus10Spin.png' || $items[$item+2] == 'plus5Spin.png'){
					$item = mt_rand(0,sizeOf($items)-1);
				}
			}
			echo $item . ',';
		}
		$item = mt_rand(0,sizeOf($items)-1);
		if ($items[$item+2] == 'plus5Spin.png' || $items[$item+2] == 'plus1Spin.png'){
			$item = mt_rand(0,sizeOf($items)-1);
		} else if ($items[$item+2] == 'plus10Spin.png'){
			$item = mt_rand(0,sizeOf($items)-1);
			if ($items[$item+2] == 'plus10Spin.png' || $items[$item+2] == 'plus5Spin.png'){
				$item = mt_rand(0,sizeOf($items)-1);
			}
		}
		echo $item;
	}
} else {
	echo '!';
}
?>