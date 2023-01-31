<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private UserService $userService)
    {

    }
    #[Route('/users')]
    public function getUsers(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        $result = '';
        foreach ($users as $user){
            $result .= $user->getId()
                . ' - '.
                $user->getLogin()
                . '<br>';
}
    return new Response($result);
}
    #[Route('/user/create', methods: ['POST'])]
    public function createUserAction(Request $request):Response
    {
        $user = $this->userService->createUser(
            $request->request->get('login'),
            $request->request->get('password'),
        );
        return new Response('User: '. $user->getId() .' '. $user->getLogin(). ' created');
}
}