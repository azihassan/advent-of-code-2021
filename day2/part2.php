<?php
$x = 0;
$y = 0;
$aim = 0;

while($line = fgets(STDIN))
{
    [$direction, $amount] = explode(' ', $line);
    switch($direction)
    {
        case 'forward':
            $x += $amount;
            $y += $aim * $amount;
        break;
        case 'down':
            $aim += $amount;
        break;
        case 'up':
            $aim -= $amount;
        break;
    }
}

echo $x * $y;
