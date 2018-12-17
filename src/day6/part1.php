<?php

$coords = array_map(function ($str) {
    return [$x, $y] = explode(', ', $str);
}, explode("\n", $input));

function manhattenDistance($point1, $point2)
{
    $sum = 0;
    for ($i = 0, $c = count($point1); $i < $c; $i++) {
        $sum += abs($point1[$i] - $point2[$i]);
    }

    return $sum;
}

$chars = range(0, count($coords));

$maxX = max(array_column($coords, 0)) + 1;
$maxY = max(array_column($coords, 1)) + 1;

$grid = array_fill(0, $maxY, array_fill(0, $maxX, null));

for ($y = 0; $y < $maxY; $y++) {
    for ($x = 0; $x <= $maxX; $x++) {
        $max = PHP_INT_MAX;

        $point = null;
        $seenDistance = [];
        foreach ($coords as $l => $coord) {

            if ([$x, $y] == $coord) {
                $point = $chars[$l];
                break;
            }

            $distance = manhattenDistance([$x, $y], $coord);

            if ($distance < $max) {
                $max = $distance;
                $point = $chars[$l];
            }

            $seenDistance[] = $distance;
        }

        $totalDistances = array_count_values($seenDistance ?? []);

        if ($totalDistances && $totalDistances[min(array_keys($totalDistances))] > 1) {
            $grid[$y][$x] = '.';
        } else {
            $grid[$y][$x] = $point;
        }
    }
}

$infinites = [];

foreach ($grid as $y => $xGrid) {
    foreach ($xGrid as $x => $item) {
        $x1 = $x - 1;
        $x2 = $x + 1;
        $y1 = $y - 1;
        $y2 = $y + 1;

        if (
            !isset($infinites[$item]) &&
            $item !== '.' && (
                !isset($grid[$y][$x1]) ||
                !isset($grid[$y][$x2]) ||
                !isset($grid[$y1][$x]) ||
                !isset($grid[$y2][$x])
            )
        ) {
            $infinites[$item] = true;
        }
    }
}

$diff = array_diff($chars, array_keys($infinites));

$total = array_fill_keys($diff, 0);
foreach ($diff as $char) {
    $total[$char] += array_sum(array_column(array_map(function ($a) { return array_count_values($a); }, $grid), $char));
}

return max($total);
