<?php
$items = scandir('images/items');
unset($items[0]);
unset($items[1]);
for ($i=2;$i<=(sizeOf($items));$i++){
	echo str_replace(".png","",$items[$i]) . ',';
}
echo str_replace(".png","",$items[sizeOf($items)+1]);
?>