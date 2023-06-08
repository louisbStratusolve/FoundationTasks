<?php

class Palindrome
{
    public static function isPalindrome($word)
    {
        $word = mb_strtolower($word);
        $word = preg_replace('/\s+/', '', $word);

        $isReallyPalindrome = true;
        $theString = str_split($word);
        $theReverseString = array_reverse($theString);

        for ($x = 0; $x <= 10; $x++) {
            if ($theString[$x] != $theReverseString[$x]) {
                $isReallyPalindrome = false;
                break;
            }
        }
        return $isReallyPalindrome;
    }
}

if (Palindrome::isPalindrome('Never Odd Or Even'))
    echo 'Palindrome';
else
    echo 'Not palindrome';
?>