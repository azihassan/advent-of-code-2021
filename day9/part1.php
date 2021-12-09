<?php
declare(strict_types=1);

class Cave
{
    public function __construct(
        private array $cave
    ) {}

    public function __toString(): string
    {
        return implode("\n", $this->cave);
    }

    public function getLowPoints(): array
    {
        $result = [];
        foreach($this->cave as $r => $row)
        {
            foreach(str_split($row) as $c => $height)
            {
                if($this->isLowPoint($r, $c))
                {
                    $result[] = $this->cave[$r][$c];
                }
            }
        }
        return $result;
    }

    private function isLowPoint(int $row, int $column): bool
    {
        $neighbors = $this->getNeighborsOf($row, $column);
        foreach($neighbors as [$r, $c])
        {
            if($this->cave[$row][$column] >= $this->cave[$r][$c])
            {
                return false;
            };
        }
        return true;
    }

    private function getNeighborsOf(int $row, int $column): array
    {
        return array_filter([
            [$row - 1, $column],
            [$row + 1, $column],
            [$row, $column - 1],
            [$row, $column + 1],
        ], fn($point) => $this->isWithinBounds($point[0], $point[1]));
    }

    private function isWithinBounds(int $row, int $column): bool
    {
        return 0 <= $row && $row < sizeof($this->cave) && 0 <= $column && $column < strlen($this->cave[0]);
    }
}

$heights = [];
while($row = fgets(STDIN))
{
    $heights[] = trim($row);
}

$cave = new Cave($heights);
$lowPoints = $cave->getLowPoints();
echo array_sum($cave->getLowPoints()) + sizeof($lowPoints), "\n";
