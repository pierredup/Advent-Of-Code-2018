<?php

function parse($chars)
{
    for ($i = 0; $i <= $c = strlen($chars); $i++) {
        if (isset($chars[$i + 1]) && 32 === abs(ord($chars[$i]) - ord($chars[$i + 1]))) {
            $chars = substr_replace($chars, '', $i, 2);
            $i -= 2;

            if ($i < -1) {
                $i = 0;
            }
        }
    }

    return $chars;
}

return strlen(parse($input));