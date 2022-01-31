<?php

declare(strict_types=1);

namespace UUP\Console\Progress;

use DomainException;
use InvalidArgumentException;

class ProgressBar
{
    private static array $spinner = ['|', '/', '-', '\\'];

    private int $startValue;
    private int $endValue;
    private int $maxLength = 20;
    private string $indicator = '=';

    private int $currentSpinner = 0;
    private int $currentPosition = 0;
    private float $percentCompleted = 0;

    /**
     * Constructor.
     * @param int $startValue The start value.
     * @param int $endValue The end value.
     */
    public function __construct(int $startValue = 0, int $endValue = 100)
    {
        $this->startValue = $startValue;
        $this->endValue = $endValue;
    }

    /**
     * Get start value.
     * @return int
     */
    public function getStartValue(): int
    {
        return $this->startValue;
    }

    /**
     * Set start value.
     * @param int $startValue
     */
    public function setStartValue(int $startValue): void
    {
        $this->startValue = $startValue;
    }

    /**
     * Get end value.
     * @return int
     */
    public function getEndValue(): int
    {
        return $this->endValue;
    }

    /**
     * Set end value.
     * @param int $endValue
     */
    public function setEndValue(int $endValue): void
    {
        $this->endValue = $endValue;
    }

    /**
     * Set max number of indicators.
     * @param int $maxLength
     */
    public function setMaxLength(int $maxLength): void
    {
        $this->maxLength = $maxLength;
    }

    /**
     * Set indicator for progress display.
     * @param string $indicator
     */
    public function setIndicator(string $indicator): void
    {
        $this->indicator = $indicator;
    }

    /**
     * Check if progress is not started.
     * @return bool
     */
    public function isStarting(): bool
    {
        return $this->percentCompleted == 0.0;
    }

    /**
     * Check if progress is finished.
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->percentCompleted == 1.0;
    }

    public function addIncrement(int $value, string $message = ""): void
    {
        $this->checkIncrementValue($value);
        $this->setPercentCompleted($value);
        $this->setCurrentPosition();

        if ($this->isStarting()) {
            $this->showProgress(0, '*', "Waiting...");
        } elseif ($this->isFinished()) {
            $this->showProgress(100, '+', "Finished!\n");
        } else {
            $this->showProgress(100 * $this->getPercentCompleted(), $this->getCurrentSpinner(), $this->getProgressBar());

            if (!empty($message)) {
                printf(": %s", $message);
            }
        }
    }

    private function getCurrentSpinner(): string
    {
        return self::$spinner[$this->currentSpinner++ % count(self::$spinner)];
    }

    private function getMaxLength(): int
    {
        return $this->maxLength;
    }

    private function getPercentCompleted(): float
    {
        return $this->percentCompleted;
    }

    private function setPercentCompleted(int $value): void
    {
        $this->percentCompleted = $value / ($this->getEndValue() - $this->getStartValue());
    }

    private function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }

    private function setCurrentPosition(): void
    {
        $this->currentPosition = intval($this->getMaxLength() * ($this->getPercentCompleted())) + 1;
    }

    private function getProgressBar(): string
    {
        return sprintf("%s%s ",
            str_repeat($this->getIndicator(), $this->getCurrentPosition()),
            str_repeat(' ', $this->getMaxLength() - $this->getCurrentPosition())
        );
    }

    private function getIndicator(): string
    {
        return $this->indicator;
    }

    private function checkIncrementValue(int $value)
    {
        if ($this->getStartValue() < 0) {
            throw new DomainException("Start value has to be larger or equal to zero");
        }
        if ($this->getStartValue() > $this->getEndValue()) {
            throw new DomainException("End value has to be larger than start value");
        }
        if ($value < $this->getStartValue() || $value > $this->getEndValue()) {
            throw new InvalidArgumentException("Value is out of range");
        }
    }

    private function showProgress(float $percent, string $spinner, string $message): void
    {
        printf("\r%s", str_repeat(' ', $this->getMaxLength() + 9));    // Clear
        printf("\r%d%% [%s] %s", $percent, $spinner, $message);
    }
}
