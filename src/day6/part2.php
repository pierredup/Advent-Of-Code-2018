<?php

$coords = array_map(function ($str) {
    return [$x, $y] = explode(', ', $str);
}, explode("\n", $input));

$chars = range(0, count($coords));

$maxX = max(array_column($coords, 0)) + 1;
$maxY = max(array_column($coords, 1)) + 1;

$grid = [];
$totalRegion = 0;
for ($y = 0; $y < $maxY; $y++) {
    for ($x = 0; $x <= $maxX; $x++) {
        $sum = 0;
        foreach ($coords as $l => $coord) {

            if ([$x, $y] == $coord) {
                $sum = 0;
                break;
            }

            $sum += manhattenDistance([$x, $y], $coord);
        }

        if (
            $sum < 10000 && (
                0 !== $sum || (
                    null !== $grid[$y][$x - 1] ||
                    null !== $grid[$y][$x + 1] ||
                    null !== $grid[$y - 1][$x] ||
                    null !== $grid[$y + 1][$x]
                )
            )
        ) {

            $grid[$y][$x] = '#';
            $totalRegion++;
        }
    }
}

return $totalRegion;

