<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleF extends Fixture
{
    private $repo;
    public function __construct(CategorieRepository $repo)
    {
        $this->repo=$repo;
    }
    public function load(ObjectManager $manager)
    {
        
    }

















}
