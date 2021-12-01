<?php
$counter = 0;
$previous = fgets(STDIN);
while($current = fgets(STDIN))
{
    $counter += $previous < $current;
    $previous = $current;
}

echo $counter;
