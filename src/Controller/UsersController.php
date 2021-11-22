<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/registration', name: 'user_subscription', methods: ['POST'])]
    public function userRegistration (Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager, ValidatorInterface $validator) : JsonResponse
    {
        $user = new Users();
        $user->setEmail($request->get('data')['email'])
             ->setFirstname($request->get('data')['firstname'])
             ->setLastname($request->get('data')['lastname'])
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
}