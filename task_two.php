<?php
function getFibonacciSequence($NumberEnteredInt) {
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


// TODO: RECURSIVE CODE MAKE TOTALLY RECURSIVE


function getFibonacciByIndexRecursive($NumberEnteredInt) {
    if ($NumberEnteredInt <= 0) {
        echo "[]";
    } if ($NumberEnteredInt == 1) {
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

echo(json_encode(getFibonacciByIndexRecursive(34)));
echo "\n";
echo(json_encode(getFibonacciSequence(34)));

?>
