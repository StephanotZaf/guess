<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PlayerRepository
 * @package App\Infrastructure\Doctrine
 */
class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    /**
     * PlayerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    /**
     * @param Player $player
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Player $player)
    {
        $this->_em->persist($player);
        $this->_em->flush();
    }
}
