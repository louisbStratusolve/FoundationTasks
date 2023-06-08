<?php

function addAllNumbersRecursive($NumbersArr) {
    $TotalSumArrayCountInt = 0;
    $SumArrayCountInt = 0;
    foreach ($NumbersArr as $NumberInt) {
        $SumArrayCountInt += $NumberInt;
    }
    $TotalSumArrayCountInt += $SumArrayCountInt;
    array_shift($NumbersArr);
    if (count($NumbersArr) > 0) {
        $TotalSumArrayCountInt += addAllNumbersRecursive($NumbersArr);
    }
    return $TotalSumArrayCountInt;
}

function addAllNumbers($NumbersArr) {
    $TotalSumArrayCountInt = 0;

    while (count($NumbersArr) > 0) {
        $SumArrayCountInt = 0;
        foreach ($NumbersArr as $NumberInt) {
            $SumArrayCountInt += $NumberInt;
        }
        $TotalSumArrayCountInt += $SumArrayCountInt;
        array_shift($NumbersArr);
    }
    return $TotalSumArrayCountInt;
}

$NumbersArr = [1, 1, 1, 1, 1]; //5+4+3+2+1=15

echo addAllNumbers($NumbersArr);
echo addAllNumbersRecursive($NumbersArr);
?>