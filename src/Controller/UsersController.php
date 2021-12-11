<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UsersController extends AbstractController
{
    #[Route('/registration', name: 'user_subscription', methods: ['POST'])]
    public function userRegistration (Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager, ValidatorInterface $validator) : JsonResponse
    {
        $user = new Users();
        $user->setEmail($request->get('data')['email'])
             ->setFirstname(ucfirst($request->get('data')['firstname']))
             ->setLastname(strtoupper($request->get('data')['lastname']))
             ->setPassword($hasher->hashPassword($user, $request->get('data')['password']))
             ->setBirthdate(new \DateTime($request->get('data')['birthdate']));

        $errors = $validator->validate($user);
        if($errors) {
            foreach($errors as $error) {
                return $this->json($error);
            }
        }

        $entityManager->persist($user);
        $entityManager->flush($user);
        return $this->json('Inscription réalisée avec succès.');
    }

    #[Route('/user', name: 'getUserDetails', methods: ['GET', 'POST'])]
    public function getUserDetails (TokenStorageInterface $tokenStorage, JWTTokenManagerInterface $JWTTokenManager) : JsonResponse
    {
        return $this->json($JWTTokenManager->decode($tokenStorage->getToken()));
    }

}