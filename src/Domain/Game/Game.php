<?php


namespace App\Domain\Game;


use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\League\League;
use App\Domain\Team\Team;

class Game
{
    private int $id;
    private string $score;
    private Team $homeTeam;
    private Team $awayTeam;
    private \DateTimeInterface $gameTime;
    private ArrayCollection $guesses;
    private League $league;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function setId(int $id): Game
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getScore(): string
    {
        return $this->score;
    }

    /**
     * @param string $score
     * @return Game
     */
    public function setScore(string $score): Game
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @param Team $homeTeam
     * @return Game
     */
    public function setHomeTeam(Team $homeTeam): Game
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * @return Team
     */
    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    /**
     * @param Team $awayTeam
     * @return Game
     */
    public function setAwayTeam(Team $awayTeam): Game
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getGameTime(): \DateTimeInterface
    {
        return $this->gameTime;
    }

    /**
     * @param \DateTimeInterface $gameTime
     * @return Game
     */
    public function setGameTime(\DateTimeInterface $gameTime): Game
    {
        $this->gameTime = $gameTime;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGuesses(): ArrayCollection
    {
        return $this->guesses;
    }

    /**
     * @param ArrayCollection $guesses
     * @return Game
     */
    public function setGuesses(ArrayCollection $guesses): Game
    {
        $this->guesses = $guesses;

        return $this;
    }

    /**
     * @return League
     */
    public function getLeague(): League
    {
        return $this->league;
    }

    /**
     * @param League $league
     * @return Game
     */
    public function setLeague(League $league): Game
    {
        $this->league = $league;

        return $this;
    }
}