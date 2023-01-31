<?php

namespace App\Services;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractEntityService
{

    protected ObjectManager $em;


    public function __construct(protected ManagerRegistry $doctrine)
    {
        $this->em = $this->doctrine->getManager();
        $this->init();
    }

    protected function init() {

    }

    protected function save(object $object = null) {
        if (!is_null($object)) {
            $this->em->persist($object);
        }
        $this->em->flush();
    }
}