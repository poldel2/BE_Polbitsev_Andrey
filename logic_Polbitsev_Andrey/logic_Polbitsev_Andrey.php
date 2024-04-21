<?php
//  ** ПЕРВАЯ ЗАДАЧА **
function isPalindrome($str)
{
    $cleanedStr = strtolower(str_replace(' ', '', $str));

    return $cleanedStr == strrev($cleanedStr);
}


//  ** ПЕРВАЯ ЗАДАЧА без функции strrev**
function isPalindrome_versionTwo($str)// Без использования функции strrev 
{ 

    $cleanedStr = strtolower(str_replace(' ', '', $str));

    $length = strlen($cleanedStr);
    for ($i = 0; $i < $length / 2; $i++) {
        if ($cleanedStr[$i] !== $cleanedStr[$length - $i - 1]) {
            return false;
        }
    }
    return true;
}


//  ** ВТОРАЯ ЗАДАЧА **
function grab_number_sum($str)
{
    $currentNumber = 0; // сколько цифр подряд идет
    $totalSum = 0;

    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        if (is_numeric($char)) {
            $currentNumber = $currentNumber * 10 + intval($char);
        } else {
            $totalSum += $currentNumber;
            $currentNumber = 0;
        }
    }
    $totalSum += $currentNumber;

    return $totalSum;
}


// ** ТРЕТЬЯ ЗАДАЧА **
function isBalanced($str)
{
    $stack = [];
    $pairs = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
    ];

    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        
        if (in_array($char, ['(', '[', '{'])) {
            array_push($stack, $char);
        } elseif (in_array($char, [')', ']', '}'])) {
            if (empty($stack)) {
                return false; 
            }
            $top = array_pop($stack);
            if ($top !== $pairs[$char]) {
                return false;
            }
        }
    }

    return true;
}

