<?php

$nodes = explode(' ', $input);

$tree = [];
$totalMetaData = 0;
function buildTree(array &$nodes)
{
    $totalMetaData = 0;
    [$numberOfChildren, $numberOfMetadata] = array_splice($nodes, 0, 2);

    if ($numberOfChildren > 0) {
        for ($i = 0; $i < $numberOfChildren; $i++) {
            $totalMetaData += buildTree($nodes);
        }
    }

    $metadata = array_splice($nodes, 0, $numberOfMetadata);

    $totalMetaData += array_sum($metadata);

    return $totalMetaData;
}

return buildTree($nodes);

