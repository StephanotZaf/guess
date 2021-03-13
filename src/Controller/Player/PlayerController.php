<?php

namespace App\Controller\Player;

use App\Application\CreatePlayerHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PlayerController.
 */
class PlayerController
{
    private CreatePlayerHandler $createPlayer;

    /**
     * PlayerController constructor.
     * @param CreatePlayerHandler $createPlayer
     */
    public function __construct(CreatePlayerHandler $createPlayer)
    {
        $this->createPlayer = $createPlayer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $playerArray = json_decode($request->getContent(), true);

        try {
            $this->createPlayer->handle(
                [
                    'username' => $playerArray['username'],
                    'email' => $playerArray['email'],
                    'password' => $playerArray['password'],
                    'avatar' => $playerArray['avatar'],
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }

        return new JsonResponse('User created');
    }
}
