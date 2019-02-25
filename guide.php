<?php
require_once('header.php');
$_SESSION['page'] = 'guide';

// set navbar element for this page to active
echo '<script>$("#' . $_SESSION['page'] . 'Nav").addClass("active");</script>';
?>

<div class="container text-center mb-5">
    <h3 class="mt-4">Spin results</h3>
    <p class="mb-4">You will receive ten xp for each pair you spin, fifty for a triple, two hundred and fifty for a quadruple and five thousand for a full set. So getting a full set will really boost your score!</p>
    <h3>Free spins</h3>
    <p class="mb-4">You can gain twenty additional spins every six hours. When you click and gain these additional spins, the countdown starts again for the next six hours. You will soon be able to purchase extra spins with real world money so that you can keep spinning away.</p>
    <h3>Score</h3>
    <p class="mb-4">The scoring system on this fruit machine is different to many other games in that it is based on your average xp per spin. This prevents the top of the leaderboard from being dominated by people who have simply spent the most time and made the most spins. Instead, people who get good spins will rank highly on the board. There may be tweaks to the scoring algorithm as more players start using the fruit machine since the margin between most players will be very small.</p>
    <h3>Stats</h3>
    <p class="mb-4">The game tracks every spin you make and the results can be viewed in the stats page along with your account information including level and xp.</p>
    <h3>Leaderboard</h3>
    <p class="mb-4">The number in blue shows the position of the player. The number in green represents that user’s score. The number in dark grey next to the username (also displayed in the header) represents the user’s level. If the user is logged in when viewing the leaderboard, their entry will be displayed at the very top. However if the user is not logged in then this will instead show the entry for the number one player.</p>
    <h3 class="mb-4">Special Items</h3>
    <div class="row">
        <img class="specialItem" src="images/items/gulhhess.png">
        <img class="specialItem" src="images/items/plus1Spin.png">
        <img class="specialItem" src="images/items/plus5Spin.png">
        <img class="specialItem" src="images/items/plus10Spin.png">
        <img class="specialItem" src="images/items/bomb.png">
    </div>
    <p class="mb-4">Beer can be used to provide two ‘beer spins’ in which you receive double xp. Beer spins are cumulative; each beer you use adds two beer spins to the beer spins count. You also get an additional two xp from each beer you gain in a spin (before the beer spin multiplier is applied).</p>
    <p class="mb-4">When at least one bomb is spun, you do not gain any xp from that spin. If you got any beer from the spin you will not receive those either. For each bomb spun, the number of beers you currently have is reduced. The more bombs that are spun, the more beers you lose with 5 bombs losing all of your beers.</p>
    <p class="mb-4">If you gain an additional spins item and there are no bombs in that spin then you will gain however many spins are indicated by the item as well as additional xp of the value of extra spins gained.</p>
    <h3 class="my-4">Items</h3>
    <div class="row">
        <?php
        $items = scandir('images/items');
        for ($i=2;$i<=(sizeOf($items)-1);$i++){
            $item = $items[$i];
            if ($item != 'bomb.png' && $item != 'gulhhess.png' && $item != 'plus10Spin.png' && $item != 'plus1Spin.png' && $item != 'plus5Spin.png') { ?>
                <div class="col-sm">
                    <img class="itemImage m-1" src="images/items/<?= $item ?>">
                    <p class="itemName"><?= str_replace('.png', '', $item) ?></p>
                </div>
            <?php }
        } ?>
    </div>
</div>