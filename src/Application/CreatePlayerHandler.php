<?php


namespace App\Application;

use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreatePlayerHandler
 * @package App\Application
 */
class CreatePlayerHandler
{
    /**
     * @var PlayerRepositoryInterface
     */
    private PlayerRepositoryInterface $playerRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * CreatePlayerHandler constructor.
     * @param PlayerRepositoryInterface $playerRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(PlayerRepositoryInterface $playerRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->playerRepository = $playerRepository;
        $this->encoder = $encoder;
    }

    /**
     * @param array $playerArray
     * @throws \Exception
     */
    public function handle(array $playerArray)
    {
        $player = new Player();
        $player->setUsername($playerArray['username']);
        $player->setEmail($playerArray['email']);
        $player->setAvatar($playerArray['avatar']);
        $player->setPassword($this->encoder->encodePassword($player, $playerArray['username']));

        try {
            $this->playerRepository->save($player);
        } catch (\Exception $exception) {
            throw new \Exception('User can not saved');
        }
    }
}
