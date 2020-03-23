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
echo memory_get_usage() / 1048576 . ' MB memory allocated after include autoload.php' . PHP_EOL; // memory debugging statement
$dataset = new FilesDataset('../../database/bbc');
$split = new StratifiedRandomSplit($dataset, 0.3);
echo memory_get_usage() / 1048576 . ' MB memory allocated after loading dataset and splitting' . PHP_EOL; // memory debugging statement
$pipeline = new Pipeline([
    new TokenCountVectorizer($tokenizer = new NGramTokenizer(1, 3), new English()),
    new TfIdfTransformer()
], new SVC(Kernel::LINEAR));
echo memory_get_usage() / 1048576 . ' MB memory allocated after loading NGramTokenizer, TfIdfTransformer, and SVC' . PHP_EOL;
$start = microtime(true);
$pipeline->train($split->getTrainSamples(), $split->getTrainLabels());
$stop = microtime(true);
echo memory_get_usage() / 1048576 . ' MB memory allocated after training' . PHP_EOL; // memory debugging statement
$predicted = $pipeline->predict($split->getTestSamples());
echo memory_get_usage() / 1048576 . ' MB memory allocated after testing' . PHP_EOL; // memory debugging statement

echo 'Train: ' . round($stop - $start, 4) . 's'. PHP_EOL;
echo 'Estimator: ' . get_class($pipeline->getEstimator()) . PHP_EOL;
echo 'Tokenizer: ' . get_class($tokenizer) . PHP_EOL;
echo 'Accuracy: ' . Accuracy::score($split->getTestLabels(), $predicted);

$modelManager = new ModelManager();
$modelManager->saveToFile($pipeline, 'bbc-nb.phpml');
