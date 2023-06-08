<?php

function addAllNumbersRecursive($Array)
{
    $TotalSumArrayCountInt = 0;
    $SumArrayCountInt = 0;
    foreach ($Array as $item) {
        $SumArrayCountInt += $item;
    }
    $TotalSumArrayCountInt += $SumArrayCountInt;
    array_shift($Array);
    if (count($Array) > 0) {
        $TotalSumArrayCountInt += addAllNumbersRecursive($Array);
    }
    return $TotalSumArrayCountInt;
}

function addAllNumbers($Array)
{
    $TotalSumArrayCountInt = 0;

    while (count($Array) > 0) {
        $SumArrayCountInt = 0;
        foreach ($Array as $item) {
            $SumArrayCountInt += $item;
        }
        $TotalSumArrayCountInt += $SumArrayCountInt;
        array_shift($Array);
    }
    return $TotalSumArrayCountInt;
}

$Array = [1, 1, 1, 1, 1]; //5+4+3+2+1=15

echo addAllNumbers($Array);
echo addAllNumbersRecursive($Array);
?>