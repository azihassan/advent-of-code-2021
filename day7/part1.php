<?php
declare(strict_types=1);
$crabs = array_map('intval', explode(',', trim(fgets(STDIN))));

$minCost = 999999999999999999;
$minPosition = $crabs[0];
for($position = min($crabs); $position <= max($crabs); $position++)
{
    $cost = calculateCost($position, $crabs);
    if($cost < $minCost)
    {
        $minCost = $cost;
        $minPosition = $position;
    }
}
echo $minCost, "\n";

function calculateCost(int $position, array $crabs): int
{
    $cost = 0;
    foreach($crabs as $crab)
    {
        $cost += abs($crab - $position);
    }
    return $cost;
}
