# Building a Laraval Web App That Incorporates Machine Learning
*By Kevin Reinholz*

## Introduction

Machine Learning is all the rage these days. That having been said, there are a lot of misconceptions about just what *Machine Learning* **is**.

When some readers think about "Machine Learning" or "Artificial Intelligence," they think *this*:

<img src='images/terminator.gif' alt='Terminator animated gif image'>

In reality, though, "Machine Learning" is more like *this*:

<img src='images/neural-network-equation.png' alt='Neural network mathematical equation'>

That's right. Machine Learning is basically *Math*. Fancy, high level Math with lots of iterations as a Cost Function is optimized to reduce the error rate and generate a good Model (a.k.a. "hypothesis").

To get the most out of Machine Learning, it would be really helpful to brush up on [Calculus](https://www.extension.harvard.edu/course-catalog/courses/multivariable-calculus/11648), [Statistics](https://www.extension.harvard.edu/course-catalog/courses/mathematical-statistics/25141), and [Linear Algebra](https://www.extension.harvard.edu/course-catalog/courses/linear-algebra/21474). While there are extremely powerful Machine Learning algorithms available for use out-of-the-box in multiple programming languages, having the proper Mathematical background to understand what they are doing and how to optimize a Cost Function, not to mention which algorithm to select in the first place, is incredibly helpful, even if you plan on using a third party library rather than writing your own.

Now before your eyes glaze over and you balk at the prospect of deep diving into *Math*, here are just a few of the amazing things data scientists have already done with Machine Learning:
+ [Spleeter](https://github.com/deezer/spleeter) - separate vocals from accompanying instruments in any song
+ [DeOldify](https://github.com/jantic/DeOldify) - colorize black and white images
+ [Replika](https://replika.ai/) - a chatbot who's always willing to listen and be a sounding board
+ Self-Driving Cars
+ Stock Market Predictors
+ Recommendation systems like those used by Netflix and Amazon
+ Personal digital assistants like Siri, Alexa, and Google Assistant

Your imagination is pretty much the limit for what can be accomplished using Machine Learning.

Although there are __amazing__ Machine Learning libraries out there--[scikit-learn](https://scikit-learn.org/stable/) and [TensorFlow](https://www.tensorflow.org/) come to mind--it really is helpful to learn the basics of Machine Learning from the ground up so you can conceptualize what is going on underneath the hood of these powerful technologies. To that end, I highly recommend [Dr. Andrew Ng of Stanford University's introductory Machine Learning course](https://www.coursera.org/learn/machine-learning). It's challenging if you don't have a strong Math background, but it does offer a brief Linear Algebra review. (You'll still get more out of it if you remember how to find a derivative, i.e. from Calculus).

Why bother learning how to write Machine Learning algorithms when infinitely more refined algorithms written by other data scientists are readily available via downloadable libraries?

<img src='images/ian-malcolm.gif' alt='Ian Malcolm Jurassic Park animated gif image'>

In seriousness, even though you might not plan on writing a competing algorithm, you'll have a much better understanding of how popular Machine Learning algorithms work and which to use on a given problem if you invest the time to practice writing your own.

A lot of Machine Learning, especially on the web, is done using **Python**. One might therefore ask, "why bother with Machine Learning in **PHP**?" That's a legitimate question. With so much work in Machine Learning done in **Python**, and the [ease of deploying your Machine Learning model to the web using the lightweight Flask framework](https://towardsdatascience.com/how-to-easily-deploy-machine-learning-models-using-flask-b95af8fe34d4), it may seem counterintuitive to bother with Machine Learning in **PHP**. After all, setting up a [Flask](https://flask.palletsprojects.com/) web app with API routes is trivial. We could easily deploy a Python-based Machine Learning model to the web this way, and provide API routes to be consumed by a [Laravel](https://laravel.com/), [Express](https://expressjs.com/), or [Ruby-on-Rails](https://rubyonrails.org/) web server, or for that matter by a pure-frontend SPA powered by [Vue](https://vuejs.org/), [Angular](https://angular.io/), [React](https://reactjs.org/), or [Ember](https://emberjs.com/), or by an [iOS](https://www.apple.com/ios/ios-13/) or [Android](https://www.android.com/) mobile app.

It really depends on the scale of your Machine Learning model and web app, but there are use cases for training, testing, and deploying a Machine Learning model in **PHP**, and serving it up from a **Laravel** web application server. For example, a small app could be housed on a single server or [DigitalOcean Droplet](https://www.digitalocean.com/products/droplets/), saving you hosting costs while allowing you to demonstrate your brilliant Machine Learning app to the world. Besides, this is a course on **PHP** and **Laravel**, so why not?

Arkadiusz Kondas has written a very useful [PHP-ML](https://github.com/php-ai/php-ml) library and made it available to **PHP** and **Laravel** developers like us. In the following guide, we're going to create a new **Laravel** project, import the **PHP-ML** library, then train and test a Machine Learning model using command line PHP, and finally save our refined model and incorporate it into a Laravel Controller so users of our app can interact with it. That's right--we're going to deploy a small Laravel app that allows users to interact with a Machine Learning model.

## Getting started -- creating a new Laravel app

Believe it or not, our first step is to create an everyday, ordinary **Laravel** app. We'll use the [CSCI E-15 Course Notes](https://hesweb.dev/e15/notes/laravel/new-laravel-app) as our guide.

First, assuming you have [XAMPP](https://hesweb.dev/e15/notes/local-server/intro) and [Composer](https://hesweb.dev/e15/notes/php/composer) installed, use the command line to enter your Github-linked directory (in the following example I'll be using my __e15__ directory):

```
λ cd C:\xampp\htdocs\e15
λ composer create-project --prefer-dist laravel/laravel classifier "7.*.*"
```
Where "classifier" is the name we're giving to our project. More on that to come. If all goes well, you should see something like this in your terminal:

<img src='images/laravel-new-project.png' alt='Creating a new Laravel project with composer'>

Which can take some time to run. If successful, you should see something like the following:

<img src='images/laravel-new-project-success.png' alt='Successfully created a new Laravel project with composer'>

Change directories to our new "classifier" app:

```
λ cd classifier
```
(Note: on a Mac or Linux machine, your command prompts will look a little different, for example starting with a dollar sign instead of a lambda like they do on my Windows 10 machine).

Since we're on a Windows machine, we don't have to worry about permissions (at least on our local server--on production, we absolutely *will*). If you're on a Mac, make sure to follow the directions [here](https://hesweb.dev/e15/notes/laravel/new-laravel-app#permissions) to ensure your Laravel app is able to run.

For convenience during development, we should absolutely follow the course instructions [here](https://hesweb.dev/e15/notes/local-server/local-domains) to set up a local domain, but for a quick and dirty test to see if our new Laravel app is running properly, direct your web browser to:

```
http://localhost/e15/classifier/public/
```
And you should see something like the following:

<img src='images/laravel-welcome.png' alt='New Laravel App Default Welcome Screen'>

Of course, we'll want to edit the following files to make this app easier to work with from our local XAMPP server:

```
C:\xampp\apache\conf\extra\httpd-vhosts.conf
C:\Windows\System32\drivers\etc\hosts
```
Following the course instructions [here](https://hesweb.dev/e15/notes/local-server/local-domains#step-2-virtualhost-entry) and [here](https://hesweb.dev/e15/notes/local-server/local-domains#step-3-create-a-new-host) to add a new VirtualHost entry (I chose `classifer.loc`) and to create a new local host. Now we can access our **Laravel** app by going to the following address in our web browser:

```
http://classifier.loc
```

That'll make further development easier/more convenient. 

Now to bring in the [PHP-ML](https://github.com/php-ai/php-ml) library:

```
λ composer require php-ai/php-ml
```
It's really that easy. If successful, you should see something like the following:

<img src='images/installing-php-ai-php-ml.png' alt='Adding PHP-AI/PHP-ML to a Laravel project'>

Success! We're going to set aside our Laravel app for the moment, and focus on the Machine Learning portion of this project--specifically, creating, training, and testing our model before packaging it up so we can serve it up to users via a [Laravel Controller](https://laravel.com/docs/master/controllers).

## Creating our Machine Learning model

At this point, our imagination (and coding/data science skills) is really the limit, but to keep this tutorial simple, I'm going to utilize one of Arkadiusz Kondas' examples so we can get back to **Laravel** integration as quickly as possible.

I found the [text classification](https://arkadiuszkondas.com/text-data-classification-with-bbc-news-article-dataset/) example Machine Learning model to be interesting enough, and to lend itself easily enough to integration with a **Laravel** app that accepts user input, to make it perfect for this example.

Before proceeding, let me explain my rationale for using one of the [PHP-ML-Examples](https://github.com/php-ai/php-ml-examples) created by Arkadiusz Kondas instead of creating my own from scratch:

1. Finding a good dataset to work with is *everything*. The bundled examples have the advantage of including ready-to-use datasets.
2. While a number of excellent datasets can be found on sites such as [Kaggle](https://www.kaggle.com/datasets), they are either difficult to download or designed for use within a cloud-based Python environment, e.g. the following:

<img src='images/kaggle-notebook.png' alt='Kaggle Notebook in Google Chrome'>

3. Finding and preparing a dataset can be a time-consuming task, and for purposes of demonstrating a **Laravel** app incorporating a Machine Learning model, using one of the [PHP-ML-Examples](https://github.com/php-ai/php-ml-examples) will save us a tremendous amount of time.

All right, so it's time to get our hands dirty with the PHP-ML library. First, we need our training/test data, so navigate to the following site in your web browser:

```
http://mlg.ucd.ie/datasets/bbc.html
```
And download the [raw text files](http://mlg.ucd.ie/files/datasets/bbc-fulltext.zip).

Extract the downloaded .zip archive someplace logical. I chose:

```
C:\xampp\htdocs\e15\classifier\database
```
Now that we have our dataset, it's time to write some PHP. Here's where we reach another dilemma: do we want to do the training and testing of our Machine Learning model within a Laravel Controller, which will lead to a very slow and unpleasant browsing experience for users of our web app, or is there a smoother way to do this?

Fortunately, there is. The PHP-ML library allows us to write command line PHP to train and test our model, then save the trained model to a file that we can import into a Laravel Controller...the already trained model will take about 1 second to run, vice a much longer run time. (The difference will become clear as I provide some benchmarks on my Hewlett Packard Notebook 15-da1005dx).

Since we installed the PHP-ML library within our Laravel app, let's create our command line PHP Machine Learning model training and testing code within our Laravel directory. I think a reasonable file location to house this file that we're going to run from the command line and not make publicly accessible would be within a newly created directory:

```
C:\xampp\htdocs\e15\classifier\resources\ml
```
So that's where we're going to create it.

<img src='images/classification-model-file-location.png' alt='Location for ML classificaiton model'>

Now to write our Machine Learning code. (Or in our case, copy the example found [here](https://github.com/php-ai/php-ml-examples/blob/master/classification/bbc.php) and [here](https://github.com/php-ai/php-ml-examples/blob/master/classification/bbcPipeline.php) and modify it for our purposes).

## Training and Testing our Machine Learning Model from the command line

First, this is what my classification-model.php file looks like:

```php
<?php

declare(strict_types=1);

use Phpml\Classification\SVC;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\FilesDataset;
use Phpml\FeatureExtraction\StopWords\English;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Metric\Accuracy;
use Phpml\ModelManager;
use Phpml\Pipeline;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\NGramTokenizer;

include '../../vendor/autoload.php';

$dataset = new FilesDataset('../../database/bbc');
$split = new StratifiedRandomSplit($dataset, 0.3);

$pipeline = new Pipeline([
    new TokenCountVectorizer($tokenizer = new NGramTokenizer(1, 3), new English()),
    new TfIdfTransformer()
], new SVC(Kernel::LINEAR));

$start = microtime(true);
$pipeline->train($split->getTrainSamples(), $split->getTrainLabels());
$stop = microtime(true);
$predicted = $pipeline->predict($split->getTestSamples());

echo 'Train: ' . round($stop - $start, 4) . 's'. PHP_EOL;
echo 'Estimator: ' . get_class($pipeline->getEstimator()) . PHP_EOL;
echo 'Tokenizer: ' . get_class($tokenizer) . PHP_EOL;
echo 'Accuracy: ' . Accuracy::score($split->getTestLabels(), $predicted);

$modelManager = new ModelManager();
$modelManager->saveToFile($pipeline, 'bbc-nb.phpml');
```
And now to set it loose on that BBC data we downloaded earlier.

```
λ php -d memory_limit=-1 classification-model.php
```
Note that I'm running the script from the command line, and that I've removed PHP's built-in memory limit (normally not a good idea, but this Machine Learning, and it's very memory intensive). Where did I learn this trick? [StackOverflow](https://stackoverflow.com/a/36000650), of course. At any rate, we're not doing something so dangerous on a production server, and our intent is to save the trained model to a file, `bbc-nb.phpml` and then run it within a Laravel Controller (without increasing any built-in PHP memory limits), so it should be OK.

Unfortunately, on my laptop, there just isn't enough memory to train our model:

<img src='images/out-of-memory.png' alt='Out of memory error on my laptop'>

One way to look for memory leaks or inefficiencies in your code is to insert statements like the following at various points throughout your code:

```php
echo memory_get_usage() / 1048576 . ' MB memory allocated after training' . PHP_EOL;
```
These statements, for example, allowed me to pinpoint that my script ran out of memory before my model could be trained. That's a shame, but I've got an HP laptop with 16GB of RAM, not a supercomputer (not that you need a supercomputer to do Machine Learning).

My nerd computer to the rescue! I pushed my classifer project to Github, then cloned it on my more capable desktop machine. Running our classification-model.php again yielded different and much more satisfying results:

<img src='images/model-trained-on-bsd.png' alt='Model had plenty of memory to run on my desktop'>

Note that it took just under 54 seconds to train and test our model on my FreeBSD machine, but the memory consumption wasn't actually that high (less than 2 GB of RAM)... It's possible upgrading the PHP version on my Windows laptop or otherwise tinkering with the settings would have allowed me to overcome the out of memory error.

The model had 97% accuracy at classifying our test data, which is not bad at all. And, importantly for our **Laravel** web app, our trained model was saved to a file, __bbc-nb.phpml__, that we can load within a Laravel Controller and use to process user input (since it would be pretty poor form for a web app to burn through over 1 GB of server RAM *and* take over 53 seconds to return results to the user!).

But what's inside our computer-generated "black box"?

<img src='images/bbc-nb-ml-generated-file.png' alt='Machine Learning generated model'>

Well...glad that clears things up! The file is approximately 250 MB in size, so it's no lightweight, either. I copied it from its save location on my FreeBSD machine to its corresponding location on my Windows development machine:

```
C:\xampp\htdocs\e15\classifier\resources\ml
```
Now we're ready to return to our **Laravel** app and direct user input to the trained Machine Learning model so we can dazzle visitors to our site with our text classification magic.

## Incorporating our trained Machine Learning model into our Laravel app

Now that we've written (or for illustrative purposes, *copied*) and trained our Machine Learning text classification model, and saved it to a file so we can leverage its power *without* the need to re-train it, it's time to incorporate the model into our **Laravel** app.

I'm not going to rehash the entire process of setting up a **Laravel** app, so you should instead refer to [Week 5](https://hesweb.dev/e15/week/5), [Week 6](https://hesweb.dev/e15/week/6), and [Week 7](https://hesweb.dev/e15/week/7) of the CSCI E-15 notes and lectures.

For purposes of getting this app ready to demonstrate, I made the following edits to the following files:

```
C:\xampp\htdocs\e15\classifier\routes\web.php
```
```php
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ClassifierController@index');
Route::get('/classify', 'ClassifierController@classify');
```
```
C:\xampp\htdocs\e15\classifier\app\Http\Controllers\ClassifierController.php
```
```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Arr;
use Str;
use Phpml\ModelManager;

class ClassifierController extends Controller
{
    public function classify(Request $request)
    {
        $request->validate([
            'articleText' => 'required|string'
        ]);

        # Note: if validation fails, it will redirect
        # back to `/` (page from which the form was submitted)

        # Get form data (default to null if no values exist)
        $articleText = $request->input('articleText', null);

        # Import saved Machine Learning model from file
        $modelManager = new ModelManager();
        $model = $modelManager->restoreFromFile('../resources/ml/bbc-nb.phpml');

        # Run our pre-trained model on the user-provided string of text
        $predicted = $model->predict([$articleText])[0];

        # Redirect back to the form with data/results stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/')->with([
            'articleText' => $articleText,
            'predicted' => $predicted
        ]);
    }

    # Initial page view--if session data exists, pre-fill form accordingly
    public function index()
    {
        return view('classifier')->with([
            'articleText' => session('articleText', null),
            'predicted' => session('predicted', null)
        ]);
    }
}
```
```
C:\xampp\htdocs\e15\classifier\resources\views\classifer.blade.php
```
```php
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
```
```
C:\xampp\htdocs\e15\classifier\public\css\classifier.css
```
```css
html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
}

.full-height {
    height: 100vh;
}

.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}

.position-ref {
    position: relative;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.content {
    text-align: center;
}

.title {
    font-size: 84px;
}

.links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}

.m-b-md {
    margin-bottom: 30px;
}

textarea {
    resize: vertical;
}

/* The following error class comes from Bootstrap
   Ref: https://github.com/twbs/bootstrap/blob/master/dist/css/bootstrap.css */
.error {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
```
Now to test our app by browsing to `http://classifier.loc` and pasting in the text of a news article...

You might receive an error message like this when testing your **Laravel** app locally:

<img src='images/php-ai-vendor-write-error.png' alt='Laravel error related to PHP-AI vendor folder write permissions'>

This is a [known issue](https://github.com/php-ai/php-ml/issues/171) and the solution is to check write permissions for the following directory:

```
classifer\vendor\php-ai\php-ml\var\
```
On my Windows 10 laptop, it turned out this folder was marked "read only", all I had to do was uncheck that box and confirm I wanted to remove the "read only" attribute from this folder and all subfolders/files contained therein.

<img src='images/var-is-read-only-by-default.png' alt='php-ai/php-ml var/ directory is read only by default on Windows'>

And then make sure computer users have write permissions to this folder as well:

<img src='images/give-laptop-users-full-control-over-var.png' alt='Making sure computer users have write access to var/'>

After apply those changes, let's try our web app again:

<img src='images/out-of-memory-laravel-app.png' alt='Even with pre-trained ML model, Laravel app runs out of memory'>

Right. That didn't go as we expected. Time to modify our `ClassifierController.php` using the advice found [here](https://haydenjames.io/understanding-php-memory_limit/):

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

ini_set('memory_limit', '2048M');
```
After which our app should have plenty of memory to complete the text processing.

## Deploying to Production

To Do...

Please note that our trained Machine Learning model is too large of a file to be uploaded to Github:

<img src='images/github-will-reject-trained-ml-model.png' alt='Trained Machine Learning model is too large to be uploaded to Github'>

As a result, we will have to manually place this on our production server via `scp`.

## Sources
+ To
+ Do
+ These are all linked to in the body of this document, but will be listed individually here as well