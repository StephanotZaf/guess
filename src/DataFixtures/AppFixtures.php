<?php

namespace App\DataFixtures;

use App\Domain\League\League;
use App\Domain\Player\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $league = (new League())
            ->setId(1)
            ->setName('Premier League')
            ->setLeagueNameSlugged('premier-league')
            ->setLeagueApiId(123)
            ->setLogo('premier-league-logo.png');
        $manager->persist($league);

        $player = new Player();
        $player->setUsername('fmo');
        $player->setEmail('test@test.com');
        $player->setPassword($this->encoder->encodePassword($player,'123123'));
        $manager->persist($player);

        $manager->flush();
    }
}
