<?php

class Palindrome
{
    public static function isPalindrome($WordStr) {
        $WordStr = mb_strtolower($WordStr);
        $WordStr = preg_replace('/\s+/', '', $WordStr);

        $IsReallyPalindromeBool = true;
        $SplitStringArr = str_split($WordStr);
        $ReverseStringArr = array_reverse($SplitStringArr);

        for ($x = 0; $x <= 10; $x++) {
            if ($SplitStringArr[$x] != $ReverseStringArr[$x]) {
                $IsReallyPalindromeBool = false;
                break;
            }
        }
        return $IsReallyPalindromeBool;
    }
}

if (Palindrome::isPalindrome('Never Odd Or Even'))
    echo 'Palindrome';
else
    echo 'Not palindrome';
?>