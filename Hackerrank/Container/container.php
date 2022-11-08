<?php

function organizingContainers($container) {
    $countContainer = [];
    foreach($container as $value) {
        array_push($countContainer, array_sum($value));
    }

    $countType = [];
    foreach($container as $item) {
        foreach($item as $key => $value) {
            if (!isset($countType[$key])) $countType[$key] = 0;
            $countType[$key] += $value;
        }
    }

    sort($countContainer, SORT_NATURAL | SORT_FLAG_CASE);
    foreach ($countContainer as $key => $val) {
        "countContainer[" . $key . "] = " . $val . "\n";
    }

    sort($countType, SORT_NATURAL | SORT_FLAG_CASE);
    foreach ($countType as $key => $val) {
        "countType[" . $key . "] = " . $val . "\n";
    }

    if($countContainer === $countType) 
        return "Possible";
    else return "Impossible";
}

echo(organizingContainers([[1,4],[2,3]]));
echo(organizingContainers([[1,1,1,1],[1,1,1,1],[1,1,1,1],[1,1,1,1]]));