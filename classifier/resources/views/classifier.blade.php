<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='/css/classifier.css' rel='stylesheet'>
        <title>New Article Classifier</title>
    </head>
    <body>
        <div class='content'>
        <header>
            <div class="title m-b-md">
                News Article Classifier Using Machine Learning
            </div>
        </header>

        <p>
            Copy and paste the text of a news article to have AI classify it into a category.
        </p>
        
        <form method='GET' action='/classify'>
            <label for='inputString'>Article text:</label>
            <input type='textarea' rows='20' cols='50' id='articleText' name='articleText' value='{{ old('articleText', $articleText) }}'> 
            <p></p>    
            @if($errors->get('articleText'))
                <div class='error'>This field must be filled out with plain text (no images) from a news article.</div>
                <p></p>
            @endif
            <button type='submit'>Classify this article</button>
        </form>
        <p></p>
        @if($predicted)
        <h2>Machine Learning Classification Results</h2>
        <p>The computer classified your article as {{ $predicted }}</p>
        <p></p>
        @endif

        <footer>
            Based on <a href='https://arkadiuszkondas.com/text-data-classification-with-bbc-news-article-dataset/'>Text data classification with BBC news article dataset</a> by Arkadiusz Kondas
        </footer>
    </div>
    </body>
</html>