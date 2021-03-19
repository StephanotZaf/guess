<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\Game\Game;
use App\Domain\Player\PlayerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class GameRepository.
 */
class GameRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    /**
     * PlayerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param Game $game
     * @return mixed
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Game $game)
    {
        $this->_em->persist($game);
        $this->_em->flush();
    }
}
