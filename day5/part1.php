<?php
declare(strict_types=1);

$lines = [];
$intersections = 0;
while($line = fgets(STDIN))
{
    [$x1, $y1, $x2, $y2] = sscanf($line, '%d,%d -> %d,%d');
    if($x1 !== $x2 && $y1 !== $y2)
    {
        continue;
    }
    if($x1 === $x2)
    {
        for($y = min($y1, $y2); $y <= max($y1, $y2); $y++)
        {
            if(!isset($lines[$y][$x1]))
            {
                $lines[$y][$x1] = 0;
            }
            if(++$lines[$y][$x1] == 2)
            {
                $intersections++;
            }
        }
    }
    else if($y1 === $y2)
    {
        for($x = min($x1, $x2); $x <= max($x1, $x2); $x++)
        {
            if(!isset($lines[$y1][$x]))
            {
                $lines[$y1][$x] = 0;
            }
            if(++$lines[$y1][$x] == 2)
            {
                $intersections++;
            }
        }
    }
}

echo $intersections, "\n";
