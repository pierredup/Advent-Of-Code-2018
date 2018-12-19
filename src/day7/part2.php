<?php

$steps = [];
$complete = $busy = [];
$timeList = array_flip(range('a', 'z'));

foreach (explode("\n", $input) as $line) {
    if (!preg_match('/Step ([A-Z]) must be finished before step ([A-Z]) can begin./', $line, $matches)) {
        continue;
    }

    [1 => $step, 2 => $requirement] = $matches;

    if (!isset($steps[$requirement])) {
        $steps[$requirement] = [
            'requirements' => [],
            'next' => [],
            'time' => ($timeList[strtolower($requirement)] + 1) + 60,
        ];
    }

    if (!isset($steps[$step])) {
        $steps[$step] = [
            'requirements' => [],
            'next' => [],
            'time' => ($timeList[strtolower($step)] + 1) + 60,
        ];
    }

    $steps[$requirement]['requirements'][] = $step;
}

function getAvailableSteps(array $steps, array $complete, array $busy)
{
    $available = [];

    foreach ($steps as $stepName => $stepInfo) {
        if ([] === array_diff($stepInfo['requirements'], array_keys($complete)) && !isset($complete[$stepName]) && !isset($busy[$stepName])) {
            $available[$stepName] = $stepInfo;
        }
    }

    ksort($available);

    return $available;
}

$workers = array_fill(0, 5, ['step' => null, 'duration' => 0]);
$totalTime = 0;

while (count($complete) !== count($steps)) {
    $nextSteps = getAvailableSteps($steps, $complete, $busy);
    $i = 0;
    foreach ($nextSteps as $step => $info) {

        assignWork:
        if ($i >= count($workers)) {
            break;
        }

        if (0 !== $workers[$i]['duration']) {
            $i++;
            goto assignWork;
        }

        $workers[$i] = [
            'step' => $step,
            'duration' => $info['time'],
        ];

        $busy[$step] = true;

        $i++;
    }

    $max = PHP_INT_MAX;
    $workerIndex = 0;

    foreach ($workers as $key => $_) {
        if (0 !== $workers[$key]['duration'] && $workers[$key]['duration'] < $max) {
            $max = $workers[$key]['duration'];
            $workerIndex = $key;
        }
    }

    $complete[$workers[$workerIndex]['step']] = true;

    $duration = $workers[$workerIndex]['duration'];
    $totalTime += $duration;
    $workers[$workerIndex] = [
        'duration' => 0,
        'step' => null,
    ];

    foreach ($workers as $i => $w) {
        $workers[$i]['duration'] -= $duration;

        if ($workers[$i]['duration'] <= 0) {
            $workers[$i] = [
                'duration' => 0,
                'step' => null,
            ];
        }
    }
}

return $totalTime;
