<?php
function getFibonacciSequence($NumberEnteredInt) {
    if($NumberEnteredInt<0){
        return [];
    }
    $ResultArr = [0,1];
    $CurrentNumber = 1;
    while(true){
        $LengthInt = count($ResultArr);
        $CurrentNumber = ($ResultArr[$LengthInt - 1] + $ResultArr[$LengthInt- 2]);
        if($CurrentNumber <= $NumberEnteredInt) {
            $ResultArr[] = $CurrentNumber;
        }else{
            break;
        }
    }
    return $ResultArr;
}


// TODO: RECURSIVE CODE MAKE TOTALLY RECURSIVE


    function getFibonacciByIndexRecursive($LastNumberInt) {
        if ($LastNumberInt <= 0) {
            return [];
        } else if ($LastNumberInt == 1) {
            return [0];
        } else {
            $ResultArr = getFibonacciSequence($LastNumberInt - 1);
            $length = count($ResultArr);
            $nextNumber = $ResultArr[$length - 1] + $ResultArr[$length - 2];
            if ($nextNumber <= $LastNumberInt) {
                $ResultArr[] = $nextNumber;
            }
            return $ResultArr;
        }
    }


    //echo(json_encode(getFibonacciByIndexRecursive(34)));
    echo(json_encode(getFibonacciSequence(-5)));

?>
