<?php
declare(strict_types=1);

$gamma = 0;
$epsilon = 0;
$bitCounter = [];

$gamma = 0;
$epsilon = 0;
$length = 0;

while($line = fgets(STDIN))
{
    $line = trim($line);
    $length = strlen($line);
    if(sizeof($bitCounter) === 0)
    {
        $bitCounter = initialize($length);
    }

    foreach(str_split($line) as $i => $bit)
    {
        $bitCounter[$i][$bit]++;

        if($bitCounter[$i][0] < $bitCounter[$i][1])
        {
            $gamma |= (1 << ($length - $i - 1));
            $epsilon &= ~(1 << ($length - $i - 1));
        }
        else
        {
            $gamma &= ~(1 << ($length - $i - 1));
            $epsilon |= (1 << ($length - $i - 1));
        }
    }
}

$consumption = $gamma * $epsilon;
echo "$gamma * $epsilon = $consumption\n";

function initialize(int $length): array
{
    return array_fill(0, $length, [0 => 0, 1 => 0]);
}
