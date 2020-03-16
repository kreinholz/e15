# Project 2
+ By: Kevin Reinholz
+ Production URL: <http://e15p2.kreinholz.me>

## Outside resources
+ English language word collection: <https://github.com/dwyl/english-words>
+ The PHP Manual hosted at https://www.php.net/manual, with individual references to specific methods noted in code comments.

## Notes for instructor
+ I originally used the array_intersect() method to look for matches between the user input string and the dictionary array of English words. This resulted in what I would consider "unexpected" behavior, as it allowed reuse of user input letters unlimited times. (Probably not what a user would be expecting if s/he was using the app to, e.g., figure out possible words s/he could make with his/her Scrabble letters). I ended up using this method as an alternate search function if the user checks a checkbox to allow duplicates.
+ The .txt file I import from Github contains over 400,000 words, many of which are arguably either not English words, or are so uncommon as to not be used. I chose this particular collection because (1) I wanted to test how fast my app could iterate over a reasonably "large" array, and (2) because the licensing allows for free use without restrictions, whereas other dictionary files I found were not so open.