<!doctype html>
<html lang='en'>
<head>
    <title>e15 Project 1</title>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width,initial-scale=1.0'>
    <link rel='icon' href='./favicon.ico' type='image/x-icon'>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
    <h1>e15 Project 1</h1>
    <form method='POST' action='process.php'>
        <label for='inputString'>Enter a string:</label>
        <input type='text' id='inputString' name='inputString'>
        <button type='submit'>Process</button>
    </form>
    <?php if (isset($results)) : ?>
        <h2>Results of Processing your String:</h2>
        <div id='results'>
            <p></p>
            <h3>Your String:</h3>
            <p></p>
            <p><?php echo $inputString; ?></p>
            <p></p>
            <h3>Is Your String a Palindrome?:</h3>
            <p></p>
            <p><?php echo $isPalindrome; ?></p>
            <p></p>
            <h3>Your String's Vowel Count:</h3>
            <p></p>
            <p><?php echo $countVowels; ?></p>
            <p></p>
            <h3>1 Letter Shift:</h3>
            <p></p>
            <p><?php echo $shiftLettersByOne; ?></p>
        </div>
    <?php endif ?>
</body>
</html>