<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\League\League;
use App\Domain\Player\PlayerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class LeagueRepository.
 */
class LeagueRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    /**
     * PlayerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, League::class);
    }

    /**
     * @param League $league
     * @return mixed
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(League $league)
    {
        $this->_em->persist($league);
        $this->_em->flush();
    }
}
