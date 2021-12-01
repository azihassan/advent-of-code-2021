<?php
$counter = 0;
$queue = new ThreeSumQueue();
$queue->enqueue(trim(fgets(STDIN)));
$queue->enqueue(trim(fgets(STDIN)));
$queue->enqueue(trim(fgets(STDIN)));

while($measurement = fgets(STDIN))
{
    $sum = $queue->getSum();
    $queue->enqueue(trim($measurement));
    $counter += $queue->getSum() > $sum;
}

echo $counter;

class ThreeSumQueue extends \SplQueue {
    private int $sum = 0;
    private int $size = 0;

    public function enqueue($value): void
    {
        parent::enqueue($value);
        $this->sum += $value;
        if(++$this->size > 3)
        {
            $this->dequeue();
        }
    }

    public function dequeue(): int
    {
        $this->size--;
        $value = parent::dequeue();
        $this->sum -= $value;
        return $value;
    }

    public function getSum(): int
    {
        return $this->sum;
    }
}
