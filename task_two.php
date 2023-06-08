<?php
if ($_POST && $_POST["fibonacciSequenceNumber"]) {

    function isPerfectSquare($x)
    {
        $s = (int)(sqrt($x));
        return ($s * $s == $x);
    }

    function isFibonacci($n)
    {
        return isPerfectSquare(5 * $n * $n + 4) ||
            isPerfectSquare(5 * $n * $n - 4);
    }

    // LOOP CODE:
    function getFibonacciSequence($lastNumber)
    {
        $outputArray = [];
        $n1 = 1;
        $n2 = 0;
        $currentValue = 0;
        while ($currentValue <= $lastNumber) {
            $outputArray[] = $n2;
            $temp = $n1 + $n2;
            $n1 = $n2;
            $n2 = $temp;
            $currentValue = $n2;
        }
        return $outputArray;
    }

// RECURSIVE CODE
    function getFibonacciByIndexRecursive($n)
    {
        if ($n == 0) {
            return 0;
        }
        if ($n == 1) {
            return 1;
        } else {
            return getFibonacciByIndexRecursive($n - 1) + getFibonacciByIndexRecursive($n - 2);
        }
    }

    function getFibonacciSequenceRecursive($lastNumber)
    {
        $currentNumberInt = 0;
        $result = 0;
        $outputArray = [];
        while ($result < $lastNumber) {
            $result = getFibonacciByIndexRecursive($currentNumberInt);
            $outputArray[] = $result;
            $currentNumberInt++;
        }
        return $outputArray;
    }

    if (isFibonacci($_POST["fibonacciSequenceNumber"])) {
        echo(json_encode(getFibonacciSequenceRecursive($_POST["fibonacciSequenceNumber"])));
        //echo(json_encode(getFibonacciSequence($_POST["fibonacciSequenceNumber"])));
    } else {
        echo $_POST["fibonacciSequenceNumber"] . " is not in the Fibonacci sequence";
    }
}
?>
