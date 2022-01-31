## UUP-PROGRESS-BAR

Progress bar for console (CLI) applications. 

```php
$progress = new ProgressBar();

for ($i = 1; $i <= 100; ++$i) {
    $progress->addIncrement($i);
}
```

Displays percentage completed, spinner and progress bar. An optional message can also be passed for each tick.

```shell
68% [\] ==============       : Importing file5483.txt
```

The start-/end-values are can be chosen as likes. Custom labels are displayed when increment value equals the start- 
or end-value:

```shell
0% [*] Waiting...
100% [+] Finished!
```

The length of the progress bar and indicator character can also be customized.
