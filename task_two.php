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
    function getFibonacciSequence($NumberEnteredInt)
    {
        if ($NumberEnteredInt < 0) {
            return [];
        }
        $ResultArr = [0, 1];
        $CurrentNumber = 1;
        while (true) {
            $LengthInt = count($ResultArr);
            $CurrentNumber = ($ResultArr[$LengthInt - 1] + $ResultArr[$LengthInt - 2]);
            if ($CurrentNumber <= $NumberEnteredInt) {
                $ResultArr[] = $CurrentNumber;
            } else {
                break;
            }
        }
        return $ResultArr;
    }

    function getFibonacciSequenceRecursive($NumberEnteredInt)
    {
        if ($NumberEnteredInt <= 0) {
            echo "[]";
        }
        if ($NumberEnteredInt == 1) {
            return [0];
        } else {
            $ResultArr = getFibonacciSequence($NumberEnteredInt - 1);
            $length = count($ResultArr);
            $nextNumber = $ResultArr[$length - 1] + $ResultArr[$length - 2];
            if ($nextNumber <= $NumberEnteredInt) {
                $ResultArr[] = $nextNumber;
            }
            return $ResultArr;
        }
    }


    // TODO: RECURSIVE CODE MAKE TOTALLY RECURSIVE

    if (isFibonacci($_POST["FibonacciSequenceNumber"])) {
        echo (json_encode(getFibonacciSequenceRecursive($_POST["FibonacciSequenceNumber"])));
        echo "\n";
        echo (json_encode(getFibonacciSequence($_POST["FibonacciSequenceNumber"])));
    } else {
        echo $_POST["FibonacciSequenceNumber"] . " is not in the Fibonacci sequence";
    }
}
