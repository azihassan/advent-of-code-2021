<?php
declare(strict_types = 1);
[$grid, $width, $height] = readGrid();

foreach(readFolds() as [$axis, $value])
{
    if($axis === 'x')
    {
        $width = $value;
    }
    else
    {
        $height = $value;
    }
    $grid = fold($grid, $axis, $value);
}
echo countVisible($grid), "\n";
printGrid($grid, $width, $height);

function printGrid(array $grid, int $width, int $height): void
{
    for($y = 0; $y < $height; $y++)
    {
        for($x = 0; $x < $width; $x++)
        {
            echo isset($grid[$y][$x]) ? '#' : '.';
        }
        echo "\n";
    }
    echo "\n";
}

function countVisible(array $grid): int
{
    $counter = 0;
    foreach($grid as $r => $row)
    {
        foreach($row as $c => $column)
        {
            $counter++;
        }
    }
    return $counter;
}

function fold(array $grid, string $axis, int $value): array
{
    return $axis === 'y' ? foldY($grid, $value) : foldX($grid, $value);
}

function foldX(array $grid, int $value): array
{
    $newGrid = [];
    foreach($grid as $r => $row)
    {
        foreach($row as $c => $column)
        {
            if($c < $value)
            {
                $newGrid[$r][$c] = '#';
                continue;
            }

            $difference = $c - $value;
            if($difference < 0)
            {
                continue;
            }
            $newGrid[$r][$value - $difference] = '#';
        }
    }
    return $newGrid;
}

function foldY(array $grid, int $value): array
{
    $newGrid = [];
    foreach($grid as $r => $row)
    {
        foreach($row as $c => $column)
        {
            if($r < $value)
            {
                $newGrid[$r][$c] = '#';
                continue;
            }

            $difference = $r - $value;
            if($difference < 0)
            {
                continue;
            }
            $newGrid[$value - $difference][$c] = '#';
        }
    }
    return $newGrid;
}

function readGrid(): array
{
    $width = 0;
    $height = 0;
    $grid = [];

    while($line = fgets(STDIN))
    {
        $line = trim($line);
        if(strlen($line) === 0)
        {
            break;
        }
        [$x, $y] = sscanf($line, '%d,%d');
        $grid[$y][$x] = '#';
        $width = max($width, $x);
        $height = max($height, $y);
    }

    return [$grid, $width + 1, $height + 1];
}

function readFolds(): \Generator
{
    $grid = [];

    while($line = fgets(STDIN))
    {
        [$axis, $value] = sscanf(trim($line), 'fold along %c=%d');
        yield [$axis, $value];
    }
}
