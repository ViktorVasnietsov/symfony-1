<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    #[Route('/main')]
    public function mainAction():Response
    {
        return new Response('Main Page');
}

}