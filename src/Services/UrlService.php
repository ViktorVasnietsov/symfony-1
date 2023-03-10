<?php

namespace App\Services;

use App\Entity\UrlCodePair;
use App\Entity\User;
use App\Shortener\Exceptions\DataNotFoundException;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class UrlService extends AbstractEntityService
{
protected ObjectRepository $repository;

    protected function init()
    {
        parent::init();
        $this->repository = $this->doctrine->getRepository(UrlCodePair::class);
}

    public function incrementUrlCounter(UrlCodePair $url): static
    {
        $url->incrementCounter();
        $this->save();
        return $this;
}

    public function getUrlByCodeAndIncrement(string $code): UrlCodePair
    {
        try {
            $url = $this->getUrlByCode($code);
            $url->incrementCounter();
            $url->setUpdatedAt();
            $this->save();
            return $url;
        }catch (\Throwable){
            throw new DataNotFoundException('Url not found by code');
        }

}
    public function getUrlByCode(string $code): UrlCodePair
    {
        try{
            return $this->repository->findOneBy(['code' => $code]);
        }catch (\Throwable){
            throw new DataNotFoundException('Url not found by code');
        }
    }

    public function getStatsByUser(?UserInterface $user = null)
    {
        try {
            return $this->repository->findBy(['user'=>$user]);
        }catch (\Throwable){
            throw new DataNotFoundException('Url not found by code');
        }
    }
}