<?php
    // LOOP CODE:
    function getFibonacciSequence($LastNumberInt) {
        $OutputArr = [];
        $N1Int = 1;
        $N2Int = 0;
        $CurrentValueInt = 0;
        while ($CurrentValueInt <= $LastNumberInt) {
            $OutputArr[] = $N2Int;
            $TempInt = $N1Int + $N2Int;
            $N1Int = $N2Int;
            $N2Int = $TempInt;
            $CurrentValueInt = $N2Int;
        }
        return $OutputArr;
    }

// RECURSIVE CODE
    function getFibonacciByIndexRecursive($NumberInt) {
        if ($NumberInt == 0) {
            return 0;
        }
        if ($NumberInt == 1) {
            return 1;
        } else {
            return getFibonacciByIndexRecursive($NumberInt - 1) + getFibonacciByIndexRecursive($NumberInt - 2);
        }
    }

    function getFibonacciSequenceRecursive($LastNumberInt) {
        $CurrentNumberInt = 0;
        $Result = 0;
        $OutputArray = [];
        while ($Result < $LastNumberInt) {
            $Result = getFibonacciByIndexRecursive($CurrentNumberInt);
            $OutputArray[] = $Result;
            $CurrentNumberInt++;
        }
        return $OutputArray;
    }

    echo(json_encode(getFibonacciSequenceRecursive(34)));
    echo(json_encode(getFibonacciSequence(34)));

?>
