<?php
$items = scandir('images/items');
unset($items[0]);
unset($items[1]);
for ($i=0;$i<4;$i++){
	echo mt_rand(0,sizeOf($items)-2) . ',';
}
echo mt_rand(0,sizeOf($items)-2);
?>