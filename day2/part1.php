<?php
$x = 0;
$y = 0;

while($line = fgets(STDIN))
{
    [$direction, $amount] = explode(' ', $line);
    switch($direction)
    {
        case 'forward':
            $x += $amount;
        break;
        case 'down':
            $y += $amount;
        break;
        case 'up':
            $y -= $amount;
        break;
    }
}

echo $x, " ", $y, "\n";
echo $x * $y;
