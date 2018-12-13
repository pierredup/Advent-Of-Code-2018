<?php

$seen = $overlap = $ids = [];

foreach (explode("\n", $input) as $line) {
    if (preg_match('/\#(?P<id>[\d]+)\s\@\s(?P<offsetleft>[\d]+),(?P<offsettop>[\d]+)\:\s(?P<width>[\d]+)x(?P<height>[\d]+)/', $line, $matches)) {
        $ids[] = $matches['id'];
        for ($y = $matches['offsetleft']; $y < $matches['offsetleft'] + $matches['width']; $y++) {
            for ($x = $matches['offsettop']; $x < $matches['offsettop'] + $matches['height']; $x++) {
                if (isset($seen["{$x}_{$y}"])) {
                    $overlap += [$seen["{$x}_{$y}"] => true, $matches['id'] => true];
                } else {
                    $seen["{$x}_{$y}"] = $matches['id'];
                }
            }
        }
    }
}

$diff = array_diff($ids, array_keys($overlap));

return end($diff);

