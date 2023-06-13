<?php

function addAllNumbersRecursive($NumbersArr, $RemoveFirstBool) {
    if (count($NumbersArr) == 0) {
        return 0;
    }
    $TotalSumArrayCountInt = 0;

    $SumArrayCountInt = 0;
    //TODO: array_sum
    foreach ($NumbersArr as $NumberInt) {
        $SumArrayCountInt += $NumberInt;
    }
    $TotalSumArrayCountInt += $SumArrayCountInt;
    $NumbersArr = shiftOrPop($NumbersArr, $RemoveFirstBool);
    $TotalSumArrayCountInt += addAllNumbersRecursive($NumbersArr, $RemoveFirstBool);

    return $TotalSumArrayCountInt;
}
function shiftOrPop($NumbersArr, $RemoveFirstBool){
    if ($RemoveFirstBool){
        array_shift($NumbersArr);
    }else{
        array_pop($NumbersArr);
    }
    return $NumbersArr;
}

function addAllNumbers($NumbersArr, $RemoveFirstBool) {
    $TotalSumArrayCountInt = 0;
    //TODO: array_sum
    while (count($NumbersArr) > 0) {
        $SumArrayCountInt = 0;
        foreach ($NumbersArr as $NumberInt) {
            $SumArrayCountInt += $NumberInt;
        }
        $TotalSumArrayCountInt += $SumArrayCountInt;
        $NumbersArr = shiftOrPop($NumbersArr, $RemoveFirstBool);
    }
    return $TotalSumArrayCountInt;
}

$NumbersArr = [1, 1, 1, 1, 5]; //5+4+3+2+1=15
echo addAllNumbers($NumbersArr, false);
echo "\n";
echo addAllNumbersRecursive($NumbersArr, false);

?>

