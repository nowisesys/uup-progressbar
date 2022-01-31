<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Console\Progress\ProgressBar;

$progress = new ProgressBar();

for ($i = 1; $i <= 100; ++$i) {
    $progress->addIncrement($i);
    usleep(10000);
}
