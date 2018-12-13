<?php

$input = explode("\n", $input);

$twice = $thrice = 0;

foreach ($input as $line) {
    $count = array_flip(array_count_values(str_split($line)));
    $twice += isset($count[2]) ? 1 : 0;
    $thrice += isset($count[3]) ? 1 : 0;
}

return $twice * $thrice;

