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

Perfect! Now to bring in the [PHP-ML](https://github.com/php-ai/php-ml) library:

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

TO DO: try running this on a more capable computer and saving the trained model, bbc-nb.phpml, to a file, so I can load it via a Laravel Controller and use it in the example web app we're going to write in the next section...

```php
<?php

declare(strict_types=1);

namespace PhpmlExamples;

use Phpml\ModelManager;

include 'vendor/autoload.php';

$start = microtime(true);
$modelManager = new ModelManager();
$model = $modelManager->restoreFromFile(__DIR__.'/../model/bbc.phpml');
$total = microtime(true) - $start;

echo sprintf('Model loaded in %ss', round($total, 4)) . PHP_EOL;

$text = 'The future of the games industry, at least as Google sees it, is in streaming.
It’s a trend that feels inevitable - just ask anyone in the music, TV or film business. Streaming is where it\'s at, and the possibility for what can be streamed has only ever been bound by the limitations of internet connectivity.
Google thinks its technology can make streaming games a plausible and possibly even pleasurable reality. One where gamers aren’t driven to insanity by stuttering gameplay and slow-reacting characters.
For the sake of argument, let’s assume it succeeds. Where might Google - with its track record for upending business models, often with unintended consequences - lead the industry?
Shifting costs
Games consoles are expensive. The games are (mostly) expensive.
Google’s Stadia could eliminate both costs, replacing them with a subscription fee. A ballpark figure might be $15-$30 a month - though some predict big name titles might have an additional fee on top, like buying a new movie on Amazon Prime Video.
Good news? It depends on where you’re coming from.
For gamers, there are a number of hurdles. Phil Harrison, Google’s man in charge of Stadia, told me his team\'s tests managed 4K gaming on download speeds of “around 25mbps”.
For context, Microsoft currently suggests a minimum of just 3mbps to play “traditional” games online. And the difference between getting 3mbps and 25mbps? Hundreds of dollars a year in payments to your internet service provider.
Or, the difference could be not being able to play at all - 25mbps is more than double the average connection speed across the US, according to research commissioned and part-funded by, er, Google.';


$start = microtime(true);

$predicted = $model->predict([$text])[0];
$total = microtime(true) - $start;

echo sprintf('Predicted category: %s in %ss', $predicted, round($total, 6)) . PHP_EOL;
```
Not that we would go exactly with the above--we don't want to run this from the command line anymore, but rather, have a Laravel Controller that takes text area input from a user, runs it through the restored pre-trained model, and outputs the category/classification to the user's hopeful amazement.