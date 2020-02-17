# Project 1
+ By: Kevin Reinholz
+ Production URL: <http://e15p1.kreinholz.me>

## Outside resources
+ <http://www.codecodex.com/wiki/Remove_non-letters_from_a_string>
+ The idea of converting characters to integers, then shifting them, came from CS50, which I took back in 2012. In that class the implementation was done in C, and was more complex as it allowed for user input and shifting characters by the integer given by the user, utilizing modulo to 'loop around' when an integer value exceeded the upper limits for characters.
+ <https://www.php.net/manual/en/function.ord.php>
+ <https://www.php.net/manual/en/function.chr.php>

## Notes for instructor
+ I struggled with 2 competing desires: (1) to avoid reusing code, typically a bad practice, and (2) to make each of my 3 string-processing functions fully self-contained (and therefore reusable). As a result, there is some redundancy between functions in terms of calling strtolower and str_split.
+ I debated using modulo to avoid having to explicitly identify 'Z' and 'z' in their integer forms and set them to 'A' and 'a' respectively, but felt that adding this computation, which is unnecessary for 50 out of 52 letters, would be a waste of computing resources given the hard-coded 1-letter shift in the project specification.