<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\User\UserSignUpDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSignUpService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;
    private UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userRepository = $userRepository;
    }

    public function signUp(UserSignUpDto $userSignUpDto): User
    {
        if (null !== $this->userRepository->findOneBy(['username' => $userSignUpDto->getUsername()])) {
            throw new LogicException("username already in use");
        }
        if (null !== $this->userRepository->findOneBy(['email' => $userSignUpDto->getEmail()])) {
            throw new LogicException("email already in use");
        }
        $user = new User();
        $user
            ->setUsername($userSignUpDto->getUsername())
            ->setEmail($userSignUpDto->getEmail())
            ->setPassword($this->userPasswordHasher->hashPassword($user, $userSignUpDto->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
