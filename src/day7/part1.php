<?php

preg_match_all('/Step ([A-Z]) must be finished before step ([A-Z]) can begin./', $input, $matches);

$requirements = [];

foreach ($matches[1] as $key => $step) {
    $requirements[$step][] = $matches[2][$key];
}

$finalSteps = array_unique(array_diff($matches[2], array_keys($requirements)));

foreach ($finalSteps as $step) {
    $requirements[$step][] = [];
}

function getRequirements(string $step, array $requirements)
{
    foreach ($requirements as $requirement) {
        if (in_array($step, $requirement)) {
            return true;
        }
    }

    return false;
}

function getNextStep(array &$steps)
{
    $availableSteps = [];
    foreach ($steps as $step => $requirements) {
        if (getRequirements($step, $steps)) {
            continue;
        }

        $availableSteps[] = $step;
    }

    sort($availableSteps);

    $nextStep = current($availableSteps);

    unset($steps[$nextStep]);

    return $nextStep;
}

$order = '';

while (!empty($requirements)) {
    $order .= getNextStep($requirements);
}

return $order;