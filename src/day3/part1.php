<?php

$seen = $overlap = [];

foreach (explode("\n", $input) as $line) {
    if (preg_match('/\#(?P<id>[\d]+)\s\@\s(?P<offsetleft>[\d]+),(?P<offsettop>[\d]+)\:\s(?P<width>[\d]+)x(?P<height>[\d]+)/', $line, $matches)) {

        for ($y = $matches['offsetleft']; $y < $matches['offsetleft'] + $matches['width']; $y++) {
            for ($x = $matches['offsettop']; $x < $matches['offsettop'] + $matches['height']; $x++) {
                if (isset($seen["{$x}_{$y}"])) {
                    $overlap[] = "{$x}_{$y}";
                } else {
                    $seen["{$x}_{$y}"] = true;
                }
            }
        }
    }
}

return count(array_unique($overlap));

