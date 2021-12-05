<?php
declare(strict_types=1);

$lines = [];
$intersections = 0;
while($line = fgets(STDIN))
{
    [$x1, $y1, $x2, $y2] = sscanf($line, '%d,%d -> %d,%d');
    if($x1 === $x2)
    {
        $intersections += addVertical($lines, $x1, min($y1, $y2), max($y1, $y2));
    }
    else if($y1 === $y2)
    {
        $intersections += addHorizontal($lines, $y1, min($x1, $x2), max($x1, $x2));
    }
    else
    {
        $intersections += addDiagonal($lines, $x1, $y1, $x2, $y2);
    }
}

echo $intersections, "\n";

function addDiagonal(array &$lines, int $x1, int $y1, int $x2, int $y2): int
{
    $intersections = 0;
    $xStep = $x1 < $x2 ? 1 : -1;
    $yStep = $y1 < $y2 ? 1 : -1;
    do
    {
        $intersections += addLine($lines, $x1, $y1);
        $x1 += $xStep;
        $y1 += $yStep;
        if(($xStep === 1 && $x1 > $x2) || ($xStep === -1 && $x1 < $x2))
        {
            break;
        }
    }
    while(true);
    return $intersections;
}

function addHorizontal(array &$lines, int $y, int $x1, int $x2): int
{
    $intersections = 0;
    for($x = $x1; $x <= $x2; $x++)
    {
        $intersections += addLine($lines, $x, $y);
    }
    return $intersections;
}

function addVertical(array &$lines, int $x, int $y1, int $y2): int
{
    $intersections = 0;
    for($y = $y1; $y <= $y2; $y++)
    {
        $intersections += addLine($lines, $x, $y);
    }
    return $intersections;
}

function addLine(array &$lines, int $x, int $y): int
{
    $intersection = 0;
    if(!isset($lines[$y][$x]))
    {
        $lines[$y][$x] = 0;
    }
    if(++$lines[$y][$x] == 2)
    {
        $intersection = 1;
    }
    return $intersection;
}
