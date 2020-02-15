<?php

session_start();

$inputString = $_POST['inputString'];

# Define a function to test whether a given string is a Palindrome
function isPalindrome($string)
{
    # Use a Regular Expression (RegEx) to remove any non-alphabetic characters from string
    $stringAlphaOnly = preg_replace('/[^A-Za-z]/', '', $string); 
    # Convert the string to lowercase so we can perform a case-insensitive comparison
    $stringLowercased = strtolower($stringAlphaOnly);
    # Reverse the characters in the string
    $stringReversed = strrev($stringLowercased);
    # Conditional check to see whether reversed string is identical to its unreversed form
    if ($stringReversed == $stringLowercased) {
        return 'Yes';
    } else {
        return 'No';
    }
}

# Define a function to test how many vowels the string contains
function countVowels($string)
{
    # Initialize the variable $vowelCount with a value of 0
    $vowelCount = 0;
    $stringLowercased = strtolower($string);
    $characterArray = str_split($stringLowercased);
    foreach($characterArray as $value) {
        if ($value == 'a' or $value == 'e' or $value == 'i' or $value == 'o' or $value == 'u') {
            $vowelCount++;
        }
    }
    return $vowelCount;
}

# Define a function that shifts ASCII letters A-Z and a-z only, by 1
function shiftLettersByOne($string)
{
    # Initialize the variable $shifted
    $shifted = null;
    $characterArray = str_split($string);
    foreach($characterArray as $value) {
        # Convert each character to an integer
        $integerizedCharacter = ord($value);
        # Conditional to only shift integers that represent letters (see ASCII table)
        if (($integerizedCharacter >= 65 and $integerizedCharacter <= 89) or ($integerizedCharacter >= 97 and $integerizedCharacter <= 121)) {
            $integerizedCharacter++;
            # convert the integer back to a character
            $value = chr($integerizedCharacter);
            # Append/concatenate the current character to the output string
            $shifted .= $value;
        }
        elseif ($integerizedCharacter == 90) {
            # convert the integer back to a character--but 'A' instead of 'Z'
            $value = chr(65);
            # Append/concatenate the current character to the output string
            $shifted .= $value;
        }
        elseif ($integerizedCharacter == 122) {
            # convert the integer back to a character--but 'a' instead of 'z'
            $value = chr(97);
            # Append/concatenate the current character to the output string
            $shifted .= $value;
        }
        else {
            # Append/concatenate the current character to the output string
            $shifted .= $value;
        }
    }
    return $shifted;
}

$_SESSION['results'] = [
    'inputString' => $inputString,
    'isPalindrome' => isPalindrome($inputString),
    'countVowels' => countVowels($inputString),
    'shiftLettersByOne' => shiftLettersByOne($inputString)
];

header('Location: index.php');