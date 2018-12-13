<?php

$events = [];
foreach (explode("\n", $input) as $line) {
    $events[strtotime(substr($line, 1, 16))] = substr($line, 19);

    ksort($events);
}

$guards = $guardTimes = [];
$sleep = $guard = null;
foreach ($events as $timestamp => $event) {
    if (preg_match('/Guard \#([\d]+) begins shift/', $event, $matches)) {
        $guard = $matches[1];
        continue;
    }

    switch ($event) {
        case 'falls asleep':
            $sleep = $timestamp;
            break;
        case 'wakes up':
            if (!isset($guards[$guard])) {
                $guards[$guard] = 0;
            }

            $guards[$guard] += ($timestamp - $sleep) / 60;
            $date = date('Y-m-d', $timestamp);

            $guardTimes[$guard] = array_merge($guardTimes[$guard] ?? [], range((int) date('i', $sleep), (int) date('i', $timestamp)));
            break;
    }
}

$guardId = array_search(max($guards), $guards);

$values = array_count_values($guardTimes[$guardId]);
asort($values);
return $guardId * array_search(max($values), $values);
