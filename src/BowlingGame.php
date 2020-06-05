<?php

namespace PF;

use PF\Exceptions\BowlingGameException;

class BowlingGame
{
    public array $rolls = [];

    private const MAXIMUM_ROLLS = 20;

    /**
     * @param int $points
     * @throws BowlingGameException
     */
    public function roll(int $points): void
    {
        $this->validateRoll($points);

        $this->rolls[] = $points;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frames = 0; $frames < 10; $frames++) {
            if ($this->isStrike($roll)) {
                $score += $this->getScoreForStrike($roll);
                $roll++;
                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getNormalScore(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return bool
     */
    private function isSpare(int $roll): bool
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return bool
     */
    private function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getScoreForStrike(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param int $points
     * @throws BowlingGameException
     */
    private function validateRoll(int $points): void
    {
        if ($points < 0 || $points > 10) {
            throw new BowlingGameException();
        }

        if (count($this->rolls) === self::MAXIMUM_ROLLS) {
            throw new BowlingGameException();
        }
    }
}