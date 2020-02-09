<?php

# Predefined string to use as a placeholder for user input
$sample_string = 'Abba';

# Define variables to hold the results of our tests
$palindrome = false;
$vowelCount = 0;

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
        $palindrome = true;
    }
}

# Define a function to test how many vowels the string contains
function countVowels($string)
{
    $characterArray = str_split($string);

}

require 'index-view.php';