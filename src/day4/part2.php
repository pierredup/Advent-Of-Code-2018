<?php

$events = [];
foreach (explode("\n", $input) as $line) {
    $events[strtotime(substr($line, 1, 16))] = substr($line, 19);

    ksort($events);
}

$mostAsleep = [];
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
            $guardTimes[$guard] = array_merge($guardTimes[$guard] ?? [], range((int) date('i', $sleep), (int) date('i', $timestamp)));

            $values = array_count_values($guardTimes[$guard]);

            if (($count = max($values)) > ($mostAsleep['count'] ?? 0)) {
                $mostAsleep = ['count' => $count, 'time' => array_search($count, $values), 'guard' => $guard];
            }
            break;
    }
}

return $mostAsleep['guard'] * $mostAsleep['time'];
