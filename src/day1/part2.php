<?php

$frequency = 0;
$parts = array_filter(explode("\n", $input));
$seen = [];

while (true) {
    foreach ($parts as $part) {
        $frequency += trim($part);

        if (isset($seen[(string) $frequency])) {
            return $frequency;
        }

        $seen[(string) $frequency] = true;
    }
}

