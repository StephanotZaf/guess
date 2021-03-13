<?php


namespace App\Domain\League;


class League
{
    private int $id;
    private string $name;
    private string $leagueNameSlugged;
    private string $logo;
    private int $leagueApiId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return League
     */
    public function setId(int $id): League
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return League
     */
    public function setName(string $name): League
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLeagueNameSlugged(): string
    {
        return $this->leagueNameSlugged;
    }

    /**
     * @param string $leagueNameSlugged
     * @return League
     */
    public function setLeagueNameSlugged(string $leagueNameSlugged): League
    {
        $this->leagueNameSlugged = $leagueNameSlugged;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return League
     */
    public function setLogo(string $logo): League
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return int
     */
    public function getLeagueApiId(): int
    {
        return $this->leagueApiId;
    }

    /**
     * @param int $leagueApiId
     * @return League
     */
    public function setLeagueApiId(int $leagueApiId): League
    {
        $this->leagueApiId = $leagueApiId;

        return $this;
    }
}