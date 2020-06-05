<?php

use PF\BowlingGame;
use PF\Exceptions\BowlingGameException;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{
    public function testGetScore_withAllZeros_getZeroScore()
    {
        // setup
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_get20asScore()
    {
        // setup
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_returnsScoreWithSquareBonus()
    {
        // setup
        $game = new BowlingGame();

        $game->roll(2);
        $game->roll(8);
        $game->roll(5);
        // 2 + 8 + 5 (square bonus) + 5 + 17
        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(37, $score);
    }

    public function testGetScore_wishAStrike_addStrikeBonus()
    {
        // setup
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(5);
        $game->roll(3);
        // 10 + 5 (bonus) + 3 (bonus) + 5 + 3 + 16
        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(42, $score);
    }

    public function testGetScore_withPerfectGame_returns300()
    {
        // setup
        $game = new BowlingGame();

        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }

        // test
        $score = $game->getScore();

        // assert
        self::assertEquals(300, $score);
    }

    public function testRoll_withInvalidNegativePoints_throwsException()
    {
        $game = new BowlingGame();

        self::expectException(BowlingGameException::class);
        $game->roll(-1);
    }

    public function testRoll_withInvalidPositivePoints_throwsException()
    {
        $game = new BowlingGame();

        self::expectException(BowlingGameException::class);
        $game->roll(42);
    }

    public function testGetScore_withInvalidRollCount_throwsException()
    {
        // setup
        $game = new BowlingGame();

        self::expectException(BowlingGameException::class);
        for ($i = 0; $i < 21; $i++) {
            $game->roll(9);
        }
    }
}