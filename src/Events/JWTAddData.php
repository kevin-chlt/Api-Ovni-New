<?php

namespace App\Events;

use App\Repository\UsersRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTAddData
{
    private $userRepository;

    public function __construct (UsersRepository $usersRepository)
    {
        $this->userRepository = $usersRepository;
    }

    public function addDataToJWT (JWTCreatedEvent $event)
    {
        $user = $this->userRepository->find($event->getUser());

        $payload = $event->getData();
        $payload['id'] = $user->getId();

        $event->setData($payload);

    }
}