<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserF extends Fixture
{

    

    private $repoProfil;
    private $encoder;
    public function __construct(ProfilRepository $repoProfil, UserPasswordEncoderInterface $encoder)
    {
        $this->repoProfil=$repoProfil;
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {

        $profils=$this->repoProfil->findAll();
        foreach ($profils as $key => $profil) {
            for ($i=0; $i < 2; $i++) { 
                $user=new User();
                $pwd=$this->encoder->encodePassword($user,strtolower($profil->getLibelle()));
                $user->setEmail(strtolower($profil->getLibelle()).$i."@gmail.com")
                    ->setNomComplet($profil->getLibelle())
                    ->setAdresse("It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here',")
                    ->setProfil($profil)
                    ->setPassword($pwd);
                    $manager->persist($user);
            }
            
        }
        $manager->flush();
    }
}
