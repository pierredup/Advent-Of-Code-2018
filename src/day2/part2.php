<?php

$input = explode("\n", $input);

for ($i = 0, $c = count($input);$i <= $c; $i++) {
    for ($k = $i + 1; $k <= $c; $k++) {
        $intersect = array_intersect_assoc($parts = str_split($input[$i]), $parts2 = str_split($input[$k] ?? ''));

        if (count($intersect) === count($parts) - 1) {
            return implode('', $intersect);
        }
    }
}

