<?php
if ($_POST && $_POST["FibonacciSequenceNumber"]) {

    function isPerfectSquare($NumberInt)
    {
        $s = (int)(sqrt($NumberInt));
        return ($s * $s == $NumberInt);
    }

    function isFibonacci($NumberInt)
    {
        return isPerfectSquare(5 * $NumberInt * $NumberInt + 4) ||
            isPerfectSquare(5 * $NumberInt * $NumberInt - 4);
    }

    // LOOP CODE:
    function getFibonacciSequence($LastNumberInt)
    {
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
    function getFibonacciByIndexRecursive($NumberInt)
    {
        if ($NumberInt == 0) {
            return 0;
        }
        if ($NumberInt == 1) {
            return 1;
        } else {
            return getFibonacciByIndexRecursive($NumberInt - 1) + getFibonacciByIndexRecursive($NumberInt - 2);
        }
    }

    function getFibonacciSequenceRecursive($LastNumberInt)
    {
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

    if (isFibonacci($_POST["FibonacciSequenceNumber"])) {
        echo(json_encode(getFibonacciSequenceRecursive($_POST["FibonacciSequenceNumber"])));
        //echo(json_encode(getFibonacciSequence($_POST["FibonacciSequenceNumber"])));
    } else {
        echo $_POST["FibonacciSequenceNumber"]." is not in the Fibonacci sequence";
    }
}
?>
