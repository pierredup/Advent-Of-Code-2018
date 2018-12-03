<?php

$input = file_get_contents(__DIR__.'/input.txt');

$frequency = 0;
$parts = array_filter(explode("\n", $input));
$seen = [];

while (true) {
    foreach ($parts as $part) {
        $frequency += trim($part);

        if (isset($seen[(string) $frequency])) {
            var_dump($frequency);
            break 2;
        }

        $seen[(string) $frequency] = true;
    }
}

