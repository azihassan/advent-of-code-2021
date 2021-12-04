<?php
declare(strict_types=1);

[$numbers, $boards] = readInput();

foreach($numbers as $draw)
{
    foreach($boards as $i => $board)
    {
        if($board->markAndCheckWinStatus($draw))
        {
            if(sizeof($boards) === 1)
            {
                $score = $board->getSumOfUnmarkedNumbers() * $draw;
                echo $board->getSumOfUnmarkedNumbers() . " * $draw = $score\n";
                exit;
            }
            unset($boards[$i]);
        }
    }
}

function readInput(): array
{
    $numbers = array_map('intval', explode(',', trim(fgets(STDIN))));

    fgets(STDIN);

    $boards = [];
    $currentBoard = [];
    while($line = fgets(STDIN))
    {
        $line = trim($line);
        if(strlen($line) === 0)
        {
            $boards[] = new Board($currentBoard);
            $currentBoard = [];
            continue;
        }
        $currentBoard[] = sscanf($line, "%d %d %d %d %d");
    }
    $boards[] = new Board($currentBoard);

    return [$numbers, $boards];
}

class Board
{
    private array $board;
    private array $positions;
    private int $width;
    private int $height;
    private int $sum = 0;

    private const DRAWN = -1;

    public function __construct(array $board)
    {
        $this->board = $board;
        foreach($board as $r => $row)
        {
            foreach($row as $c => $square)
            {
                $this->positions[$square][] = [$r, $c];
                $this->sum += $square;
            }
        }
        $this->width = sizeof($board[0]);
        $this->height = sizeof($board);
    }

    public function markAndCheckWinStatus(int $number): bool
    {
        if(!array_key_exists($number, $this->positions))
        {
            return false;
        }
        $this->sum -= $number;
        foreach($this->positions[$number] as [$row, $column])
        {
            $this->board[$row][$column] = self::DRAWN;
            if($this->hasWon($row, $column))
            {
                return true;
            }
        }
        return false;
    }

    public function getSumOfUnmarkedNumbers(): int
    {
        return $this->sum;
    }

    public function display(): void
    {
        foreach($this->board as $row)
        {
            echo implode("\t", array_map(fn($square) => $square === self::DRAWN ? '[ ]' : "[$square]", $row));
            echo "\n";
        }
        printf("\n");
    }

    private function hasWon(int $row, int $column): bool
    {
        return $this->hasMarkedRow($row) || $this->hasMarkedColumn($column);
    }

    private function hasMarkedRow(int $row): bool
    {
        for($c = 0; $c < $this->width; $c++)
        {
            if($this->board[$row][$c] !== self::DRAWN)
            {
                return false;
            }
        }
        return true;
    }

    private function hasMarkedColumn(int $column): bool
    {
        for($r = 0; $r < $this->height; $r++)
        {
            if($this->board[$r][$column] !== self::DRAWN)
            {
                return false;
            }
        }
        return true;
    }
}
