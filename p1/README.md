# Project 1
+ By: Kevin Reinholz
+ Production URL: <http://e15p1.kreinholz.me>

## Outside resources
+ <http://www.codecodex.com/wiki/Remove_non-letters_from_a_string>
+ <https://www.php.net/manual/en/language.variables.scope.php>
+ <https://www.php.net/manual/en/function.ord.php>
+ <https://www.php.net/manual/en/function.chr.php>

## Notes for instructor
I struggled with 2 competing desires: (1) to avoid reusing code, typically a bad practice, and (2) to make each of my 3 string-processing functions fully self-contained (and therefore reusable). As a result, there is some redundancy between functions in terms of calling strtolower and str_split. Since both functions rely on global variables anyway, perhaps this processing should have been done outside of the 3 named functions, but I felt it was better style to make each as "self contained" as possible.