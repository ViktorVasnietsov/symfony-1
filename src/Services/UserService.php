<?php

namespace App\Services;

use App\Entity\User;
use App\Exceptions\ObjectCantSaveException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class UserService
{
    protected ObjectManager $em;
    protected ObjectRepository $userRepository;

    public function __construct(protected ManagerRegistry $doctrine)
    {
        $this->em = $this->doctrine->getManager();
        $this->userRepository = $this->doctrine->getRepository(User::class);
    }

    /**
     * @throws ObjectCantSaveException
     */
    public function createUser(string $login, string $password):User
    {
        try{
            $user = new User($login,$password);
            $this->loginValidator($login);
            $this->save($user);
            return $user;
        }catch (\Exception $e){
            throw new ObjectCantSaveException('User not saved', previous: $e);
        }
    }

    public function save(object $object): void
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    /**
     * @throws ObjectCantSaveException
     */
    public function loginValidator(string $login): void
    {
            $users = $this->userRepository;
            if($users->findOneBy(['login'=>$login])){
                throw new ObjectCantSaveException('error, this login is already exist');
            }

        }


}