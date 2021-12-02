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
        $user = $this->userRepository->findOneBy(['id' => $event->getUser()]);

        $payload = $event->getData();
        $payload['firstname'] = $user->getFirstname();
        $payload['lastname'] = $user->getLastname();

        $event->setData($payload);

    }
}