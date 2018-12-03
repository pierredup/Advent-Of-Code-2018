<?php

$input = file_get_contents(__DIR__.'/input.txt');


var_dump(array_sum(explode("\n", $input)));
