<?php
    // LOOP CODE:
    function getFibonacciSequence($LastNumberInt) {
        $OutputArr = [0,1]; //TODO ADD IN
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

// TODO: RECURSIVE CODE MAKE TOTALLY RECURSIVE
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
        $ResultInt = 0;
        $OutputArr = [];
        while ($ResultInt < $LastNumberInt) {
            $ResultInt = getFibonacciByIndexRecursive($CurrentNumberInt);
            $OutputArr[] = $ResultInt;
            $CurrentNumberInt++;
        }
        return $OutputArr;
    }

    echo(json_encode(getFibonacciSequenceRecursive(69)));
    echo(json_encode(getFibonacciSequence(69)));

?>
