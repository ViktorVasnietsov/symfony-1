<?php

namespace App\Shortener;

use App\Entity\UrlCodePair;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeRepository;
use App\Shortener\ValueObjects\UrlCodePair as UrlCodePairVO;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CodePairRepository implements ICodeRepository
{
    protected ObjectRepository $cpRepository;
    protected ObjectManager $em;

    public function __construct(protected ManagerRegistry $doctrine, protected Security $security)
    {
        $this->em = $this->doctrine->getManager();
        $this->cpRepository = $this->doctrine->getRepository(UrlCodePair::class);
    }
    public function saveEntity(UrlCodePairVO $urlCodePairVO): bool
    {
        try {
            $user = $this->security->getUser();
            $result = true;
            $codePair = new UrlCodePair($urlCodePairVO->getUrl(), $urlCodePairVO->getCode(), $user);
            $this->em->persist($codePair);
            $this->em->flush();
        }catch (\Throwable){
            $result = false;
        }
        return $result;
    }

    public function codeIsset(string $code): bool
    {
        return (bool)$this->cpRepository->findOneBy(['code'=>$code]);
    }

    public function getUrlByCode(string $code): string
    {
try{
    /**
     * @var \App\Entity\UrlCodePair $codePair
     */
    $codePair = $this->cpRepository->findOneBy(['code'=>$code]);
    return $codePair->getUrl();
}catch (\Throwable){
    throw new DataNotFoundException('Url not found by code');
}
    }

    public function getCodeByUrl(string $url): string
    {
        try{
            /**
             * @var \App\Entity\UrlCodePair $codePair
             */
            $codePair = $this->cpRepository->findOneBy(['url'=>$url]);

            return $codePair->getCode();
            }catch (\Throwable){
            throw new DataNotFoundException('Code not found');
        }
    }
}