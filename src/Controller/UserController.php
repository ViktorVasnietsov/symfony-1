<?php
//
//namespace App\Controller;
//
//use App\Entity\User;
//use Doctrine\ORM\EntityManager;
//use Doctrine\Persistence\ObjectRepository;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class UserController
//{
//    private ObjectRepository $ur;
//    private EntityManager $entityManager;
//
//    public function __construct(EntityManager $entityManager)
//    {
//        $this->entityManager = $entityManager;
//        $this->ur = $entityManager->getRepository(User::class);
//    }
//    #[Route('/users')]
//public function getUsers()
//{
//$users = $this->ur->findAll();
//$result = '';
//foreach ($users as $user){
//    $result .= $user->getLogin()
//        . '<br>';
//}
//return new Response($result);
//}
//
//}