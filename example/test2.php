<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use UUP\Console\Progress\ProgressBar;

$progress = new ProgressBar();

$progress->setStartValue(1);
$progress->setEndValue(400);
$progress->setMaxLength(10);
$progress->setIndicator('*');

for ($i = 1; $i < 400; ++$i) {
    $progress->addIncrement($i);
    usleep(10000);
}
