<?php

declare(strict_types=1);

namespace App\Http\Controllers;

ini_set('memory_limit', '2048M');

use Illuminate\Http\Request;
use Arr;
use Str;

use Phpml\ModelManager;

include '../../../vendor/autoload.php';

$articleText = "Canada's multi-billion-dollar relief package to respond to the coronavirus slowdown has passed in the Senate.  It allows the government to spend C$82bn ($57bn, £48bn) in emergency aid and economic stimulus.  The bill received approval on Wednesday with support from all parties, after amendments that removed provisions giving cabinet unprecedented powers.  The bill is scheduled to get Royal Assent later on Wednesday.  Legislators passed the package, worth about 3% of the country's GDP, after a debate in the House of Commons that went into the early morning hours.  Prime Minister Justin Trudeau had promised to push the bill through parliament this week.      Canadian PM Trudeau's wife tests positive for coronavirus  Local governments have been increasing social-distancing measures to stem the spread of coronavirus, which has led thousands of businesses to close their doors.  The federal government has received nearly one million claims for unemployment benefits last week, which is equivalent to about 5%";

        # Import saved Machine Learning model from file
        $modelManager = new ModelManager();
        $model = $modelManager->restoreFromFile('../../../resources/ml/bbc-nb.phpml');
$start = microtime(true);
        # Run our pre-trained model on the user-provided string of text
        $predicted = $model->predict([$articleText])[0];
$stop = microtime(true);

echo 'Time: ' . round($stop - $start, 4) . 's'. PHP_EOL;
echo $predicted;
